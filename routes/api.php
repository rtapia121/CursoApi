<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserTokenController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProductRatingController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', ProductController::class)->middleware('auth:sanctum');
Route::post('/token', UserTokenController::class)->name('token');
Route::post('/newsletter',[NewsletterController::class,'send'])->name('newsletter');

Route::post('products/{product}/rate', [ProductRatingController::class, 'rate']);
Route::post('products/{product}/unrate', [ProductRatingController::class, 'unrate']);
