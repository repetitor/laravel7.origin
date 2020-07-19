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
 * try quickly)
 */
//Route::get('user/{id}', 'ShowProfile');
Route::get('try', 'Quick');
Route::get('try-get', 'Quick@get');

/*
 * auth
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

/*
 * users
 */
Route::get('users/{user}/phone', 'UserController@phone');
Route::get('phones/{phone}/user', 'PhoneController@user');
Route::apiResource('users', 'UserController')->except('store');

/*
 * fligths
 */
// // show route -> breaks my other actions)
//Route::get('/flights/{flight}', function (\App\Flight $flight) {
//    return $flight;
//    return App\Flight::findOrFail($flight->id); // => big json if not found (404 Not Found)
////    return App\Flight::find($id); // => empty if not found (200 OK)
//});
// my other actions
Route::get('flights/my-action', 'FlightController@myAction');
Route::get('flights/my-action-2', 'FlightController@myAction2');
// other routes
//Route::resource('flights', 'FlightController')->except(['show']);
//Route::apiResource('flights', 'FlightController')->except(['show']);
Route::apiResource('flights', 'FlightController');

Route::get('posts/{post}/comments', 'PostController@comments');
Route::apiResources([
//    'photos' => 'PhotoController',
    'posts' => 'PostController',
    'comments' => 'CommentController',
    'phones' => 'PhoneController',
]);
