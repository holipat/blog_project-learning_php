<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThemeController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::delete('posts/{post}/delete-image', [PostController::class, 'deleteImage'])->name('posts.delete-image');

// Theme routes
Route::get('theme/{theme}', [ThemeController::class, 'toggle'])->name('theme.toggle');
