<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SessionAuthMiddleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use PHPUnit\Framework\Attributes\PostCondition;

Route::get('/', function () {
    return Inertia::render('LoginPage');
});

// User related route
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::get('/registration-page', [UserController::class, 'RegistrationPage']);
Route::post('/user-registration', [UserController::class, 'UserRegistration']);

Route::get('/feed-page', [BlogController::class, 'FeedPage']);


// Blog related route

Route::middleware(SessionAuthMiddleware::class)->group(function () {

    // Post related route
    Route::get('/create-post-page', [PostController::class, 'CreatePostPage']);
    Route::post('/create-post', [PostController::class, 'CreatePost']);

    Route::get('/edit-post-page/{id}', [PostController::class, 'EditPostPage']);
    Route::post('/edit-post/{id}', [PostController::class, 'EditPost']);

    Route::get('/view-post/{id}', [PostController::class, 'ViewPost']);

    // Post Delete Related Route
    Route::get('post-delete/{id}', [PostController::class, 'PostDelete']);

    // Post like related
    Route::get('/post/{id}/like', [PostController::class, 'PostLike']);
    Route::get('/post/{id}/unlike', [PostController::class, 'PostUnlike']);

    //  Post Book Mark related Route
    Route::get('/post/{id}/bookmark', [PostController::class, 'Bookmark']);
    Route::get('/post/{id}/unbookmark', [PostController::class, 'UnBookmark']);
    Route::get('/my-posts-page', [PostController::class, 'MyPostPage']);
    Route::get('/bookmarks-page', [PostController::class, 'BookmarksPage']);

    // Post Comment related route
    Route::post('/add-comment', [PostController::class, 'AddComment']);

    // User Logout
    Route::post('/logout', [UserController::class, 'logout']);
});