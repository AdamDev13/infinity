<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BidSubmissionController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectQuestion;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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




Route::get('/states', [AuthController::class, 'getStates']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink']);
Route::post('/reset/password', [AuthController::class,'callResetPassword']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset_password', [AuthController::class, 'ProfileResetPassword']);
    Route::prefix('/profile')->group(function () {
        Route::post('/', [AuthController::class, 'updateProfile']);
        Route::get('/', [AuthController::class, 'getProfile']);
    });

    Route::prefix('/project')->group(function () {
        Route::get('/state/{state}/county',[ProjectController::class,'getCountyByState']);
        Route::get('/favorite', [ProjectController::class, 'getFavorite']);
        Route::get('/viewed', [ProjectController::class, 'getViewed']);

        Route::prefix('/question')->group(function () {
            Route::post('/', [ProjectQuestion::class, 'create']);
            Route::get('/{project_id}', [ProjectQuestion::class, 'getQuestionByProject']);
            Route::get('/', [ProjectQuestion::class, 'index']);
        });

        Route::post('/{id}/favorite', [ProjectController::class, 'favorite']);
        Route::post('/{id}/unfavorite', [ProjectController::class, 'Unfavorite']);
        Route::get('/{id}', [ProjectController::class, 'show']);
        Route::get('/', [ProjectController::class, 'getProjects']);
    });

    Route::prefix('/bid-submissions')->group(function () {

        Route::post('/withdraw', [BidSubmissionController::class, 'withdraw']);
        Route::post('/', [BidSubmissionController::class, 'store']);
        Route::get('/', [BidSubmissionController::class, 'index']);
    });

});


