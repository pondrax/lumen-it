<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_route', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('menu_id')->constrained('app_menu');
            $table->string('prefix');
            $table->string('route');
            $table->string('middleware');
            $table->string('controller')->unique();
            $table->string('method');
            $table->timestamps();
        });
        
        DB::table('app_route')->insert([
        
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/role/{id}', 'middleware' => 'auth', 'controller' => 'App\RoleController@read', 'method' => 'GET'],
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/role', 'middleware' => 'auth', 'controller' => 'App\RoleController@create', 'method' => 'POST'],
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/role/{id}', 'middleware' => 'auth', 'controller' => 'App\RoleController@update', 'method' => 'PUT'],
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/role/{id}', 'middleware' => 'auth', 'controller' => 'App\RoleController@delete', 'method' => 'DELETE'],
			
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/user/{id}', 'middleware' => 'auth', 'controller' => 'App\UserController@read', 'method' => 'GET'],
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/user', 'middleware' => 'auth', 'controller' => 'App\UserController@create', 'method' => 'POST'],
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/user/{id}', 'middleware' => 'auth', 'controller' => 'App\UserController@update', 'method' => 'PUT'],
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/user/{id}', 'middleware' => 'auth', 'controller' => 'App\UserController@delete', 'method' => 'DELETE'],
			
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/menu/{id}', 'middleware' => 'auth', 'controller' => 'App\MenuController@read', 'method' => 'GET'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/menu', 'middleware' => 'auth', 'controller' => 'App\MenuController@create', 'method' => 'POST'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/menu/{id}', 'middleware' => 'auth', 'controller' => 'App\MenuController@update', 'method' => 'PUT'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/menu/{id}', 'middleware' => 'auth', 'controller' => 'App\MenuController@delete', 'method' => 'DELETE'],
			
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/route/{id}', 'middleware' => 'auth', 'controller' => 'App\RouteController@read', 'method' => 'GET'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/route', 'middleware' => 'auth', 'controller' => 'App\RouteController@create', 'method' => 'POST'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/route/generate', 'middleware' => 'auth', 'controller' => 'App\RouteController@generate', 'method' => 'POST'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/route/{id}', 'middleware' => 'auth', 'controller' => 'App\RouteController@update', 'method' => 'PUT'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/route/{id}', 'middleware' => 'auth', 'controller' => 'App\RouteController@delete', 'method' => 'DELETE'],
			
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/access/{id}', 'middleware' => 'auth', 'controller' => 'App\AccessController@read', 'method' => 'GET'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/access', 'middleware' => 'auth', 'controller' => 'App\AccessController@create', 'method' => 'POST'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/access/{id}', 'middleware' => 'auth', 'controller' => 'App\AccessController@update', 'method' => 'PUT'],
			['menu_id' => 1	, 'prefix' => 'api', 'route' => 'app/access/{id}', 'middleware' => 'auth', 'controller' => 'App\AccessController@delete', 'method' => 'DELETE'],
			
			['menu_id' => 2	, 'prefix' => 'api', 'route' => 'app/log/{id}', 'middleware' => 'auth', 'controller' => 'App\LogController@read', 'method' => 'GET'],
		
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_route');
    }
}
