<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
    // return $router->app->version();
// });

/* Main API Route */
$router->group(['prefix'=>'api'], function() use ($router){
	$router->get('logs/{id}'	, "App\LogController@read");

	
	/* Log everything */
	$router->group(['middleware'=>['logger']], function() use ($router){	
		
		$router->post('auth/register'	, "App\AuthController@register");
		$router->post('auth/login'		, "App\AuthController@login");
		
		$router->get('role'			, "App\RoleController@index");
		$router->get('role/{id}'	, "App\RoleController@read");
		$router->post('role'		, "App\RoleController@create");
		$router->put('role/{id}'	, "App\RoleController@update");
		$router->delete('role/{id}'	, "App\RoleController@delete");

	
		/* Only admin allowed */
		$router->group(['middleware'=>['auth']], function() use ($router){
				
		});
	});
});
