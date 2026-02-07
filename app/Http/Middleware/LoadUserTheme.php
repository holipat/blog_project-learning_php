<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\ThemeController;

class LoadUserTheme
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mevcut temaları tanımla
        $validThemes = [
            'default',
            'cutie',
            'ocean',
            'sunset',
            'forest',
            'midnight',
            'cotton-candy',
            'wizard-grimoire'
        ];
        
        // Kullanıcı giriş yaptıysa ve tema tercihini kaysaydıysa
        if (auth()->check() && auth()->user()->theme_preference) {
            $theme = auth()->user()->theme_preference;
        } else {
            // Session'dan ya da default'tan tema al
            $theme = session('theme', 'default');
        }
        
        // Tema geçerli mi kontrol et
        if (!in_array($theme, $validThemes)) {
            $theme = 'default';
        }
        
        // Session'a ata
        session(['theme' => $theme]);
        
        return $next($request);
    }
}
