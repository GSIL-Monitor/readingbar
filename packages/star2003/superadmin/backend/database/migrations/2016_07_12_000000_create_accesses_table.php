<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('access');
            $table->timestamps();
        });
        	DB::table('accesses')->insert([
	        	'name' => 'user',
	        	'access' => 'admin.user',
        		'created_at' => date('Y-m-d H:i:s',time()),
	        	'updated_at' => date('Y-m-d H:i:s',time()),
        	]);
        	DB::table('accesses')->insert([
        		'name' => 'role',
        		'access' => 'admin.role',
        		'created_at' => date('Y-m-d H:i:s',time()),
	        	'updated_at' => date('Y-m-d H:i:s',time()),
        	]);
        	DB::table('accesses')->insert([
        		'name' => 'access',
        		'access' => 'admin.access',
        		'created_at' => date('Y-m-d H:i:s',time()),
	        	'updated_at' => date('Y-m-d H:i:s',time()),
        	]);
            DB::table('accesses')->insert([
                'name' => 'menu',
                'access' => 'admin.menu',
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
        Schema::drop('accesses');
    }
}
