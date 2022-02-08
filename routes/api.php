<?php

use App\Http\Controllers\ValidateController;
use App\Http\Middleware\AuthenticationTokenValid;
use App\Http\Middleware\ValidateAppId;
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

//Login doesn't require the user token to be presence. Only the app id needs to be validate.
Route::post('/login', 'AuthController@login')->middleware([ValidateAppId::class]);

//validation route
Route::get('/validate/token', [ValidateController::class, 'token']);
Route::get('/validate/user-token', [ValidateController::class, 'userToken']);
Route::get('/validate/app', [ValidateController::class, 'app'])->middleware(ValidateAppId::class);


Route::middleware([ValidateAppId::class, AuthenticationTokenValid::class, 'auth:user-token'])->group(function() {

    //add API's that require the user token (AT token)
    Route::get('/companies', 'AuthController@companies');
    Route::post('/company', 'AuthController@company');
    Route::post('/logout', 'AuthController@logout');

});