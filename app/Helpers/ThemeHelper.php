<?php

namespace App\Helpers;

class ThemeHelper
{
    /**
     * Get the current theme
     */
    public static function getCurrentTheme(): string
    {
        return session('theme', 'default');
    }
    
    /**
     * Get available themes
     */
    public static function getAvailableThemes(): array
    {
        return [
            ['id' => 'default', 'name' => 'Default', 'colors' => '#9d7bff, #6ab7ff'],
            ['id' => 'ocean', 'name' => 'Ocean', 'colors' => '#2ba8d4, #00bfb3'],
            ['id' => 'sunset', 'name' => 'Sunset', 'colors' => '#ff9f5a, #ff7185'],
            ['id' => 'forest', 'name' => 'Forest', 'colors' => '#4a9b6f, #6ac491'],
            ['id' => 'midnight', 'name' => 'Midnight', 'colors' => '#4a5aed, #6c7cff'],
            ['id' => 'cotton-candy', 'name' => 'Cotton Candy', 'colors' => '#f5a3d9, #b5a7ff'],
        ];
    }
    
    /**
     * Check if a theme is currently active
     */
    public static function isThemeActive(string $theme): bool
    {
        return self::getCurrentTheme() === $theme;
    }
    
    /**
     * Get theme name by ID
     */
    public static function getThemeName(string $themeId): ?string
    {
        $themes = self::getAvailableThemes();
        foreach ($themes as $theme) {
            if ($theme['id'] === $themeId) {
                return $theme['name'];
            }
        }
        return null;
    }
}
