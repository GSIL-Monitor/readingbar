<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->string('avatar');
            $table->string('email')->unique();
            $table->integer('role');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        	DB::table('users')->insert([
	        	'name' => 'admin',
				'avatar'=> '',
	        	'email' => 'admin@star2003.com',
	        	'role' => 1,
	        	'password' => bcrypt('123456'),
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
        Schema::drop('users');
    }
}
