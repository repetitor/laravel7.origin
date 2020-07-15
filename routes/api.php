<?php

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

/*
 * user
 *
 * if you will see message: "Personal access client not found. Please create one."
 * => php artisan passport:install
 *
 * p.s. don't worry if you will see message: "Encryption keys already exist. Use the --force option to overwrite them."
 */
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// origin route
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', 'AuthController@logout')->middleware('auth:api');
