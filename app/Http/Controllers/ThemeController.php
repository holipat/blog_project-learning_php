<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Toggle theme
     */
    public function toggle(Request $request, $theme)
    {
        // List of available themes
        $availableThemes = [
            'default',
            'cutie',
            'ocean',
            'sunset',
            'forest',
            'midnight',
            'cotton-candy',
            'wizard-grimoire'
        ];
        
        // Validate theme exists
        if (!in_array($theme, $availableThemes)) {
            return back()->with('error', 'Tema bulunamadı!');
        }
        
        // Store theme in session
        session(['theme' => $theme]);
        
        // If user is authenticated, save to database
        if (auth()->check()) {
            auth()->user()->update(['theme_preference' => $theme]);
        }
        
        return back()->with('success', 'Tema değiştirildi! ✨');
    }
    
    /**
     * Load user's saved theme or default
     */
    public static function loadUserTheme()
    {
        if (auth()->check() && auth()->user()->theme_preference) {
            session(['theme' => auth()->user()->theme_preference]);
        } else {
            session(['theme' => session('theme', 'default')]);
        }
    }
    
    /**
     * Get all available themes
     */
    public static function getAvailableThemes()
    {
        return [
            ['id' => 'default', 'name' => 'Default', 'colors' => '#9d7bff, #6ab7ff'],
            ['id' => 'cutie', 'name' => 'Cutie', 'colors' => '#8b7cff, #7fd3ff'],
            ['id' => 'ocean', 'name' => 'Ocean', 'colors' => '#2ba8d4, #00bfb3'],
            ['id' => 'sunset', 'name' => 'Sunset', 'colors' => '#ff9f5a, #ff7185'],
            ['id' => 'forest', 'name' => 'Forest', 'colors' => '#4a9b6f, #6ac491'],
            ['id' => 'midnight', 'name' => 'Midnight', 'colors' => '#4a5aed, #6c7cff'],
            ['id' => 'cotton-candy', 'name' => 'Cotton Candy', 'colors' => '#f5a3d9, #b5a7ff'],
            ['id' => 'wizard-grimoire', 'name' => 'Wizard Grimoire', 'colors' => '#d4af37, #9d4edd'],
        ];
    }
}

