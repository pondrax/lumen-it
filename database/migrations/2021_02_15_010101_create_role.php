<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');
            $table->text('description');
            $table->timestamps();
        });
        
        DB::table('app_role')->insert([
			['role' => 'Developer'		, 'description' => 'Main Developer'],
			['role' => 'Administrator'	, 'description' => 'Administrator'],
			['role' => 'Editor'			, 'description' => 'Editor'],
			['role' => 'Member'			, 'description' => 'Member'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_role');
    }
}
