<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create-user', [UserController::class, 'create']);
Route::get('get-all-users', [UserController::class, 'get']);
Route::get('get-user-{id}', [UserController::class, 'get_id']);


Route::get('get-animes-{offset}', [AnimeController::class, 'get']);
Route::get('get-anime-{id}', [AnimeController::class, 'get_id']);
Route::get('get-anime-name-{name}', [AnimeController::class, 'get_name']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('role:admin')->group(function() {
        Route::delete('delete-comment-{id}', [CommentController::class, 'delete']);
        Route::put('ban-user-{id}', [UserController::class, 'ban']);

        Route::post('create-anime', [AnimeController::class, 'create']);
        Route::put('update-anime-{id}', [AnimeController::class, 'update']);
        Route::delete('delete-anime-{id}', [AnimeController::class, 'delete']);
    });
    
    Route::middleware('role:manager')->group(function() {
        Route::delete('delete-comment-{id}', [CommentController::class, 'deleteComment']);
    });
    
    Route::post('create-comment', [CommentController::class, 'create']);
    Route::get('read-comments-{offser}', [CommentController::class, 'get']);
    Route::put('update-comment-{id}', [CommentController::class, 'update']);
    Route::delete('delete-comment-my-{id}', [CommentController::class, 'delete_my']);
    
    Route::put('update-user-{id}', [UserController::class, 'update']);
    Route::put('delete-user-{id}', [UserController::class, 'delete']);
    Route::post('update-user-{id}', [UserController::class, 'update_file']);
});