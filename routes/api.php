<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ArticleController;

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

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {
    Route::get('articles', [ArticleController::class, 'articlesList']);
    Route::get('articles/{id}', [ArticleController::class, 'articlePage']);
    Route::get('articles/{id}/comment', [ArticleController::class, 'articleComment']);
    Route::post('articlesCommentCreate', [ArticleController::class, 'articleCommentCreate']);
    Route::get('articles/{id}/like', [ArticleController::class, 'articleLike']);
    Route::get('articles/{id}/view', [ArticleController::class, 'articleView']);
});
