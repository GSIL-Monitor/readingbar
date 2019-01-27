<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('accesses');
            $table->timestamps();
        });
        	DB::table('roles')->insert([
        		'name' => 'superadmin',
        		'created_at' => date('Y-m-d H:i:s',time()),
        		'updated_at' => date('Y-m-d H:i:s',time()),
        	]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
