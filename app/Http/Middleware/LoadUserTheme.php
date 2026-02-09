<?php

namespace App\Http\Middleware;

use App\Services\ThemeConfig;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadUserTheme
{
    /**
     * Default theme ID
     */
    private const DEFAULT_THEME = 'default';

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $theme = $this->resolveTheme($request);
        
        // Validate and normalize theme
        $theme = ThemeConfig::normalizeTheme($theme);
        
        // Store validated theme in session
        session(['theme' => $theme]);
        
        // Share theme with all views
        view()->share('currentTheme', $theme);
        
        return $next($request);
    }

    /**
     * Resolve theme from user session, database, or default
     */
    private function resolveTheme(Request $request): string
    {
        // 1. Check if user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            
            // Use user's theme preference from database
            if ($user->theme_preference) {
                return $user->theme_preference;
            }
        }
        
        // 2. Check session
        $sessionTheme = $request->session()->get('theme');
        if ($sessionTheme !== null) {
            return $sessionTheme;
        }
        
        // 3. Check request cookie
        $cookieTheme = $request->cookie('theme');
        if ($cookieTheme !== null && ThemeConfig::isValidTheme($cookieTheme)) {
            return $cookieTheme;
        }
        
        // 4. Fallback to default
        return self::DEFAULT_THEME;
    }
}
