<?php

namespace App\Http\Controllers;

use App\Services\ThemeConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ThemeController extends Controller
{
    /**
     * Cache TTL for theme preferences (in seconds)
     */
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Toggle theme
     */
    public function toggle(Request $request, $theme)
    {
        // Validate theme exists using centralized config
        if (!ThemeConfig::isValidTheme($theme)) {
            return back()->with('error', 'Tema bulunamadı!');
        }
        
        // Store theme in session
        session(['theme' => $theme]);
        
        // If user is authenticated, save to database and cache
        if (auth()->check()) {
            $user = auth()->user();
            $user->update(['theme_preference' => $theme]);
            
            // Cache the theme preference for faster lookups
            Cache::put(
                self::getUserThemeCacheKey($user->id),
                $theme,
                self::CACHE_TTL
            );
        }
        
        return back()->with('success', 'Tema değiştirildi! ✨');
    }
    
    /**
     * Load user's saved theme or default (with caching)
     */
    public static function loadUserTheme()
    {
        $theme = ThemeConfig::getDefaultTheme();
        
        if (auth()->check()) {
            $userId = auth()->id();
            
            // Try cache first for authenticated users
            $cachedTheme = Cache::get(self::getUserThemeCacheKey($userId));
            
            if ($cachedTheme !== null) {
                $theme = $cachedTheme;
            } elseif (auth()->user()->theme_preference) {
                $theme = auth()->user()->theme_preference;
                
                // Populate cache
                Cache::put(
                    self::getUserThemeCacheKey($userId),
                    $theme,
                    self::CACHE_TTL
                );
            }
        } else {
            // For guests, use session with default fallback
            $theme = session('theme', ThemeConfig::getDefaultTheme());
        }
        
        // Validate and normalize theme
        $theme = ThemeConfig::normalizeTheme($theme);
        session(['theme' => $theme]);
    }
    
    /**
     * Get all available themes (using centralized config)
     */
    public static function getAvailableThemes(): array
    {
        $themes = ThemeConfig::getThemes();
        
        // Transform to the expected format for views
        $formattedThemes = [];
        foreach ($themes as $id => $theme) {
            $formattedThemes[] = [
                'id' => $id,
                'name' => $theme['name'],
                'colors' => $theme['colors']
            ];
        }
        
        return $formattedThemes;
    }

    /**
     * Get current theme from session (optimized version)
     */
    public static function getCurrentTheme(): string
    {
        return session('theme', ThemeConfig::getDefaultTheme());
    }

    /**
     * Generate cache key for user theme
     */
    private static function getUserThemeCacheKey(int $userId): string
    {
        return "user:{$userId}:theme_preference";
    }
}
