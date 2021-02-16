<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu');
            $table->integer('num');
            $table->timestamps();
        });
        
        DB::table('app_menu')->insert([
			['menu' => 'Developer'	, 'num' => 99],
			['menu' => 'App'		, 'num' => 98],
			['menu' => 'Dashboard'	, 'num' => 1],
			['menu' => 'Data'		, 'num' => 2],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_menu');
    }
}
