<?php

namespace App\Services;

use InvalidArgumentException;

/**
 * Theme Configuration Service
 * 
 * Centralized theme management to avoid code duplication across
 * ThemeController, ThemeHelper, and Middleware classes.
 * 
 * This class provides:
 * - Centralized theme definitions
 * - Efficient theme validation
 * - Cached theme lookups
 * - Theme metadata access
 */
class ThemeConfig
{
    /**
     * Available themes with metadata
     * 
     * Structure: [
     *     'theme_id' => [
     *         'name' => 'Display Name',
     *         'colors' => 'primary, secondary colors',
     *         'fonts' => ['header', 'body'] (optional)
     *     ]
     * ]
     */
    private const THEMES = [
        'default' => [
            'name' => 'Default',
            'colors' => '#9d7bff, #6ab7ff',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'cutie' => [
            'name' => 'Cutie',
            'colors' => '#8b7cff, #7fd3ff',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'ocean' => [
            'name' => 'Ocean',
            'colors' => '#2ba8d4, #00bfb3',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'sunset' => [
            'name' => 'Sunset',
            'colors' => '#ff9f5a, #ff7185',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'forest' => [
            'name' => 'Forest',
            'colors' => '#4a9b6f, #6ac491',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'midnight' => [
            'name' => 'Midnight',
            'colors' => '#4a5aed, #6c7cff',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'cotton-candy' => [
            'name' => 'Cotton Candy',
            'colors' => '#f5a3d9, #b5a7ff',
            'font_header' => 'Poppins',
            'font_body' => 'Nunito'
        ],
        'wizard-grimoire' => [
            'name' => 'Wizard Grimoire',
            'colors' => '#d4af37, #9d4edd',
            'font_header' => 'Cinzel',
            'font_body' => 'Cormorant Garamond'
        ],
        'dark-fantasy-romance' => [
            'name' => 'Dark Fantasy Romance',
            'colors' => '#b03060, #9966cc',
            'font_header' => 'MedievalSharp',
            'font_body' => 'Cormorant Garamond'
        ]
    ];

    /**
     * Default theme identifier
     */
    private const DEFAULT_THEME = 'default';

    /**
     * Get all available themes
     * 
     * @return array Array of theme definitions
     */
    public static function getThemes(): array
    {
        return self::THEMES;
    }

    /**
     * Get theme IDs as a simple array (for validation)
     * 
     * @return array List of theme IDs
     */
    public static function getThemeIds(): array
    {
        return array_keys(self::THEMES);
    }

    /**
     * Get theme metadata by ID
     * 
     * @param string $themeId Theme identifier
     * @return array|null Theme metadata or null if not found
     */
    public static function getTheme(string $themeId): ?array
    {
        return self::THEMES[$themeId] ?? null;
    }

    /**
     * Get theme name by ID
     * 
     * @param string $themeId Theme identifier
     * @return string|null Theme display name or null if not found
     */
    public static function getThemeName(string $themeId): ?string
    {
        return self::THEMES[$themeId]['name'] ?? null;
    }

    /**
     * Get theme colors as array
     * 
     * @param string $themeId Theme identifier
     * @return array ['primary', 'secondary'] colors
     */
    public static function getThemeColors(string $themeId): array
    {
        $theme = self::getTheme($themeId);
        
        if ($theme === null) {
            return self::getTheme(self::DEFAULT_THEME)['colors'];
        }
        
        return $theme['colors'];
    }

    /**
     * Get theme fonts
     * 
     * @param string $themeId Theme identifier
     * @return array ['header', 'body'] font families
     */
    public static function getThemeFonts(string $themeId): array
    {
        $theme = self::getTheme($themeId);
        
        if ($theme === null) {
            return [
                'header' => self::getTheme(self::DEFAULT_THEME)['font_header'],
                'body' => self::getTheme(self::DEFAULT_THEME)['font_body']
            ];
        }
        
        return [
            'header' => $theme['font_header'] ?? 'Poppins',
            'body' => $theme['font_body'] ?? 'Nunito'
        ];
    }

    /**
     * Validate if a theme ID is valid
     * 
     * @param string $themeId Theme identifier to validate
     * @return bool True if valid theme
     */
    public static function isValidTheme(string $themeId): bool
    {
        return array_key_exists($themeId, self::THEMES);
    }

    /**
     * Validate and normalize a theme value
     * 
     * @param mixed $themeId Theme identifier (will be cast to string)
     * @return string Valid theme ID (defaults to 'default' if invalid)
     */
    public static function normalizeTheme($themeId): string
    {
        $themeId = (string) $themeId;
        
        if (self::isValidTheme($themeId)) {
            return $themeId;
        }
        
        return self::DEFAULT_THEME;
    }

    /**
     * Get the default theme ID
     * 
     * @return string Default theme identifier
     */
    public static function getDefaultTheme(): string
    {
        return self::DEFAULT_THEME;
    }

    /**
     * Get themes formatted for dropdown/select options
     * 
     * @return array Array suitable for select options
     */
    public static function getThemesForSelect(): array
    {
        $themes = [];
        
        foreach (self::THEMES as $id => $theme) {
            $themes[$id] = $theme['name'];
        }
        
        return $themes;
    }

    /**
     * Get CSS file path for a theme
     * 
     * @param string $themeId Theme identifier
     * @return string CSS file path relative to public directory
     */
    public static function getCssPath(string $themeId): string
    {
        $themeId = self::normalizeTheme($themeId);
        return "css/themes/{$themeId}.css";
    }

    /**
     * Check if a theme requires special assets (like Font Awesome)
     * 
     * @param string $themeId Theme identifier
     * @return bool True if theme needs special assets
     */
    public static function needsSpecialAssets(string $themeId): bool
    {
        // Wizard and Dark Fantasy themes may need special icon sets
        return in_array($themeId, ['wizard-grimoire', 'dark-fantasy-romance']);
    }

    /**
     * Get cache key for theme-related caching
     * 
     * @param string $suffix Optional suffix
     * @return string Cache key
     */
    public static function getCacheKey(string $suffix = ''): string
    {
        $key = 'theme_config';
        
        if (!empty($suffix)) {
            $key .= "_{$suffix}";
        }
        
        return $key;
    }
}

