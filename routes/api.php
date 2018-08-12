<?php

use Illuminate\Http\Request;

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


// API route group that we need to protect
Route::group( [ 'middleware' => [ 'jwt.auth' ] ], function () {
	// Protected route
	Route::get( 'user', function ( Request $request ) {
		return auth()->user();
	} );
	Route::get( 'logout', 'JwtAuthenticateController@logout' );
	Route::get( 'refresh-token', 'JwtAuthenticateController@refreshToken' );

	// Product routes
	Route::resource( 'products', 'ProductController' );
	Route::post( 'products/checkUniqueCode', 'ProductController@checkUniqueCode' );
} );

// API route group that we need to protect
Route::group( [ 'middleware' => [ 'ability:admin' ] ], function () {
	// Route to get all users
	Route::get( 'users', 'JwtAuthenticateController@index' );

	// Route to create a new role
	Route::post( 'role', 'JwtAuthenticateController@createRole' );
	// Route to create a new permission
	Route::post( 'permission', 'JwtAuthenticateController@createPermission' );
	// Route to assign role to user
	Route::post( 'assign-role', 'JwtAuthenticateController@assignRole' );
	// Route to attache permission to a role
	Route::post( 'attach-permission', 'JwtAuthenticateController@attachPermission' );

} );

Route::post( 'user/register', 'APIRegisterController@register' );
Route::post( 'user/login', 'APILoginController@login' );

// Authentication route
Route::post( 'authenticate', 'JwtAuthenticateController@authenticate' );
