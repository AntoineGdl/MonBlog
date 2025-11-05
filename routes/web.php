<?php

use App\Http\Controllers\Api\RepostController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirection de la page d'accueil
Route::redirect('/', '/articles');

// Routes pour les invités
Route::middleware('guest')->group(function () {
    // Authentication
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Routes nécessitant une authentification
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Articles
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('articles/{article}/like', [ArticleController::class, 'like'])->name('articles.like');

    // Commentaires
    Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('articles.comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Accès à son profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

// Routes publiques des articles
Route::resource('articles', ArticleController::class)->except(['create', 'store']);
