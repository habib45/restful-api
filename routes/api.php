<?php

use App\Http\Controllers\API\V1\GroupController;
use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\ChannelController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\TrackController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\ExternalApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::POST("login",[LoginController::class,'login']);
    //---------Admin Routing----------
    Route::middleware('auth:sanctum')->group(function () {
        Route::POST('logout', [LoginController::class, 'logout'])->name('logout');
        // Users routes
        Route::controller(UserController::class)->group(function () {
            Route::GET('users', 'index');
            Route::GET('users/{id}', 'show')->where('id', '[0-9]+');
            Route::POST('users', 'store');
            Route::PUT('users/{id}', 'update');
            Route::GET('users/profile','profile');
            Route::DELETE('/users/{id}', 'destroy');
            Route::GET('/profile', function (Request $request) {
                return $request->user();
            });
        });

        // Groups routes
        Route::controller(GroupController::class)->group(function () {
            Route::GET('groups', 'index');
            Route::GET('groups/{id}', 'show')->where('id', '[0-9]+');
            Route::POST('groups', 'store');
            Route::PUT('groups/{id}', 'update');
            Route::DELETE('groups/{id}', 'destroy');
            Route::GET('groups/list', 'getGroupList');
        });


        // channel routes
        Route::controller(ChannelController::class)->group(function () {
            Route::GET('channels',  'index');
            Route::GET('channels/{id}',  'show')->where('id', '[0-9]+');
            Route::POST('channels', 'store');
            Route::PUT('channels/{id}', 'update');
            Route::DELETE('channels/{id}', 'destroy');
            Route::GET('channels/list', 'getChannelList');
        });


        // project routes
        Route::controller(ProjectController::class)->group(function () {
            Route::GET('projects',  'index');
            Route::GET('projects/{id}',  'show');
            Route::POST('projects', 'store');
            Route::PUT('projects/{id}', 'update');
            Route::DELETE('projects/{id}', 'destroy');
        });
        // track routes
        Route::controller(TrackController::class)->group(function () {
            Route::GET('tracks',  'index');
            Route::GET('tracks/{id}',  'show')->where('id', '[0-9]+');
            Route::GET('tracks/list', 'getList');
            Route::POST('tracks', 'store');
            Route::PUT('tracks/{id}', 'update');
            Route::DELETE('tracks/{id}', 'destroy');
        });


        // External Api routes
        Route::controller(ExternalApiController::class)->group(function () {
            Route::GET('external-apis',  'index');
            Route::GET('external-apis/{id}',  'show')->where('id', '[0-9]+');
            Route::GET('external-apis/list', 'getList');
            Route::POST('external-apis', 'store');
            Route::PUT('external-apis/{id}', 'update');
            Route::DELETE('external-apis/{id}', 'destroy');
        });

    });
});

