<?php

namespace App\Helpers;

use App\Services\ThemeConfig;

class ThemeHelper
{
    /**
     * Get the current theme
     */
    public static function getCurrentTheme(): string
    {
        return session('theme', ThemeConfig::getDefaultTheme());
    }
    
    /**
     * Get available themes (using centralized config)
     */
    public static function getAvailableThemes(): array
    {
        return ThemeConfig::getThemes();
    }
    
    /**
     * Check if a theme is currently active
     */
    public static function isThemeActive(string $theme): bool
    {
        return self::getCurrentTheme() === $theme;
    }
    
    /**
     * Get theme name by ID (using centralized config)
     */
    public static function getThemeName(string $themeId): ?string
    {
        return ThemeConfig::getThemeName($themeId);
    }
    
    /**
     * Get theme colors by ID
     */
    public static function getThemeColors(string $themeId): string
    {
        return ThemeConfig::getThemeColors($themeId);
    }
    
    /**
     * Get theme CSS path
     */
    public static function getThemeCssPath(string $themeId): string
    {
        return ThemeConfig::getCssPath($themeId);
    }
    
    /**
     * Validate if a theme is valid
     */
    public static function isValidTheme(string $themeId): bool
    {
        return ThemeConfig::isValidTheme($themeId);
    }
    
    /**
     * Normalize theme value
     */
    public static function normalizeTheme($themeId): string
    {
        return ThemeConfig::normalizeTheme($themeId);
    }
}
