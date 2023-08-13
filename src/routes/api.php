<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){
    //Route::apiResource('issues', IssueController::class);

    Route::post('/issues', [IssueController::class, 'store']);
    Route::put('/issues/{issue}', [IssueController::class, 'update']);
    Route::get('/issues', [IssueController::class, 'index']);
    Route::delete('/issues/{id}', [IssueController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'users']);
    Route::get('/user', [UserController::class, 'user']);

    Route::post('/issues/{issue}/comments', [IssueController::class, 'createComment']);
    Route::get('/issues/{issue}/comments', [IssueController::class, 'getComments']);

    Route::post('/comments/{comment}/replies', [CommentController::class, 'reply']);
    Route::get('/comments/{comment}/replies', [CommentController::class, 'replies']);

    Route::get('/logs', [LogController::class, 'logs']);
});