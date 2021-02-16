<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_access', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('role_id')->constrained('app_role');
            $table->foreignId('route_id')->constrained('app_route');
            $table->timestamps();
        });
        
        DB::table('app_access')->insert([
        
			['role_id' => 1	, 'route_id' => 1],
			['role_id' => 1	, 'route_id' => 2],
			['role_id' => 1	, 'route_id' => 3],
			['role_id' => 1	, 'route_id' => 4],
			['role_id' => 1	, 'route_id' => 5],
			['role_id' => 1	, 'route_id' => 6],
			['role_id' => 1	, 'route_id' => 7],
			['role_id' => 1	, 'route_id' => 8],
			['role_id' => 1	, 'route_id' => 9],
			['role_id' => 1	, 'route_id' => 10],
			['role_id' => 1	, 'route_id' => 11],
			['role_id' => 1	, 'route_id' => 12],
			['role_id' => 1	, 'route_id' => 13],
			['role_id' => 1	, 'route_id' => 14],
			['role_id' => 1	, 'route_id' => 15],
			
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_access');
    }

}
