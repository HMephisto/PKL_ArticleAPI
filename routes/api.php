<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------|
| API Routes                                                               |
|--------------------------------------------------------------------------|
|                                                                          
| Here is where you can register API routes for your application. These    
| routes are loaded by the RouteServiceProvider within a group which       
| is assigned the "api" middleware group. Enjoy building your API!         
|                                                                          
*/

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:api')->get('/usera', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'getAllUser']);
        Route::get('/{user_id}', [UserController::class, 'getUserDetail']);
        Route::get('/{user_id}/content', [UserController::class, 'getUserContent']);
        Route::put('/{user_id}', [UserController::class, 'editUser']);
        Route::post('/profile/upload', [UserController::class, 'uploadFile']);
        Route::post('/follow', [UserController::class, 'follow']);
        Route::get('/{user_id}/followers', [UserController::class, 'getUserFollowers']);
        Route::get('/{user_id}/followings', [UserController::class, 'getUserFollowings']);
    });
    Route::prefix('/articles')->group(function () {
        Route::get('/', [ArticleController::class, 'getAllArticle']);
        Route::get('/banner', [ArticleController::class, 'getBanner']);
        Route::post('/', [ArticleController::class, 'addArticle']);
        Route::get('/{article_id}', [ArticleController::class, 'getArticleDetail']);
        Route::put('/{article_id}', [ArticleController::class, 'editArticle']);
        Route::delete('/{article_id}', [ArticleController::class, 'deleteArticle']);
        Route::post('/upload', [ArticleController::class, 'uploadFile']);
        Route::post('/{article_id}/like', [ArticleController::class, 'like']);
    });
});
