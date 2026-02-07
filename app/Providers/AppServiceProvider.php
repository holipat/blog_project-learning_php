<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Uygulama hizmetlerini kaydet
     */
    public function register(): void
    {
        //
    }

    /**
     * Uygulama hizmetlerini başlat
     */
    public function boot(): void
    {
        // Post model'i için policy'yi kaydet
        Gate::policy(Post::class, PostPolicy::class);
    }
}

