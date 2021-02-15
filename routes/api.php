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

/* Main API Route */
$router->group(['prefix'=>'api','middleware'=>'formdata'], function() use ($router){
	
	$router->get('app/logs/{id}'	, "App\LogController@read");
	
	/* Log everything */
	$router->group(['middleware'=>['logger']], function() use ($router){	
		
		$router->post('auth/register'	, "App\AuthController@register");
		$router->post('auth/login'		, "App\AuthController@login");
	
		/* Only admin allowed */
		$router->group(['middleware'=>['logger']], function() use ($router){

			$router->get('app/role'			, "App\RoleController@index");
			$router->get('app/role/{id}'	, "App\RoleController@read");
			$router->post('app/role'		, "App\RoleController@create");
			$router->put('app/role/{id}'	, "App\RoleController@update");
			$router->delete('app/role/{id}'	, "App\RoleController@delete");

			$router->get('app/user'			, "App\UserController@index");
			$router->get('app/user/{id}'	, "App\UserController@read");
			$router->post('app/user'		, "App\UserController@create");
			$router->put('app/user/{id}'	, "App\UserController@update");
			$router->delete('app/user/{id}'	, "App\UserController@delete");
					
			$router->get('app/menu'			, "App\MenuController@index");
			$router->get('app/menu/{id}'	, "App\MenuController@read");
			$router->post('app/menu'		, "App\MenuController@create");
			$router->put('app/menu/{id}'	, "App\MenuController@update");
			$router->delete('app/menu/{id}'	, "App\MenuController@delete");
			
			$router->get('app/route'		, "App\RouteController@index");
			$router->get('app/route/{id}'	, "App\RouteController@read");
			$router->post('app/route'		, "App\RouteController@create");
			$router->put('app/route/{id}'	, "App\RouteController@update");
			$router->delete('app/route/{id}', "App\RouteController@delete");
			
			$router->get('app/access'		, "App\AccessController@index");
			$router->get('app/access/{id}'	, "App\AccessController@read");
			$router->post('app/access'		, "App\AccessController@create");
			$router->put('app/access/{id}'	, "App\AccessController@update");
			$router->delete('app/access/{id}', "App\AccessController@delete");
			
		});
	});
});
