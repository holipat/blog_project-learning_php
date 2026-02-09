<?php

namespace App\View\Composers;

use App\Services\ThemeConfig;
use Illuminate\View\View;

class ThemeComposer
{
    /**
     * Bind theme data to the view.
     */
    public function compose(View $view): void
    {
        $themes = [];
        foreach (ThemeConfig::getThemes() as $id => $theme) {
            $themes[] = [
                'id' => $id,
                'name' => $theme['name'],
                'colors' => $theme['colors']
            ];
        }

        $view->with([
            'availableThemes' => $themes,
            'currentTheme' => session('theme', 'default')
        ]);
    }
}

