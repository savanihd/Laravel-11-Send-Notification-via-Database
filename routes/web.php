<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}/approve', [PostController::class, 'approve'])->name('posts.approve');
Route::get('/notifications/{id}/mark-as-read', [PostController::class, 'markAsRead'])->name('notifications.mark.as.read');
