<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use App\View\Composers\ThemeComposer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register theme configuration service as singleton
        $this->app->singleton(\App\Services\ThemeConfig::class, function ($app) {
            return new \App\Services\ThemeConfig();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Post model'i için policy'yi kaydet
        Gate::policy(Post::class, PostPolicy::class);

        // Register view composer for theme data
        View::composer('layouts.app', ThemeComposer::class);

        // Preload frequently accessed data into cache
        $this->preloadCache();
    }

    /**
     * Preload frequently accessed data into cache
     */
    private function preloadCache(): void
    {
        // Only preload in production to avoid unnecessary work in development
        if (app()->environment('production')) {
            try {
                // Cache theme list for 24 hours
                Cache::remember('themes:all', 86400, function () {
                    return \App\Services\ThemeConfig::getThemes();
                });
            } catch (\Exception $e) {
                // Cache system might not be available, silently fail
                // Logging could be added here if needed
            }
        }
    }
}

