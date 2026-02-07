<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Resource route: Yukarıdaki 7 metod için otomatik route oluşturur
Route::resource('posts', PostController::class);
Route::delete('/posts/{post}/delete-image', [PostController::class, 'deleteImage'])
    ->name('posts.delete-image');
/*Route::get('/', function () {
Route::get('/ana-sayfa', [SiteController::class, 'index']);
Route::get('/hakkimizda', [SiteController::class, 'hakkimizda']);
Route::get('/anasayfa', [SiteController::class, 'anasayfa']);

Route::get('/merhaba', function () {
    return 'Merhaba Dünya! İlk Laravel Route\'um!';
});

    return view('welcome');
});*/
