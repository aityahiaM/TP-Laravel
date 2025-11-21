<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //PARTIE BREEZE 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //Afficher le tableau de bord (profile.blade.php) avec toutes les sections principales
    Route::get('/dashboard', [ProfileController::class, 'profile'])->name('dashboard');
    //Afficher la liste de tous les utilisateurs
    Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
    
    //PARTIE FOLLOW & UNFOLLOW 
    //TODO : Créer une route POST pour permettre à un utilisateur de suivre un autre utilisateur
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    //TODO : Créer une route DELETE pour permettre à un utilisateur de ne plus suivre un autre utilisateur
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
    

    //PARTIE NOTIFICATION 
    Route::post('/notifications/{notification}/mark-as-read', [ProfileController::class, 'markAsRead'])->name('notifications.markAsRead');

    //PARTIE POSTS 
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    

    //PARTIE LIKE
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like.toggle');

    //PARTIE COMMENTAIRE 
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('comments.store');
});

require __DIR__.'/auth.php';
