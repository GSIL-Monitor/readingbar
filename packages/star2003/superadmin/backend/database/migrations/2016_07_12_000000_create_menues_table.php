<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatemenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('access');
            $table->string('url');
            $table->integer('pre_id');
            $table->integer('rank');
            $table->integer('status');
            $table->integer('display');
            $table->string('icon');
            $table->timestamps();
        });
         DB::table('menues')->insert([
                'name' => 'system',
                'access'=>'',
                'url'=>'',
                'pre_id'=>'0',
                'rank'=>'1',
                'status'=>'1',
                'display'=>'1',
                'icon'=>'fa-th-large',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
         DB::table('menues')->insert([
                'name' => 'user',
                'access'=>'admin.user',
                'url'=>'admin/user',
                'pre_id'=>'1',
                'rank'=>'2',
                'status'=>'1',
                'display'=>'2',
                'icon'=>'',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
         DB::table('menues')->insert([
                'name' => 'role',
                'access'=>'admin.role',
                'url'=>'admin/role',
                'pre_id'=>'1',
                'rank'=>'2',
                'status'=>'1',
                'display'=>'3',
                'icon'=>'',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
         DB::table('menues')->insert([
                'name' => 'access',
                'access'=>'admin.access',
                'url'=>'admin/access',
                'pre_id'=>'1',
                'rank'=>'2',
                'status'=>'1',
                'display'=>'4',
                'icon'=>'',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
         DB::table('menues')->insert([
	         'name' => 'menu',
	         'access'=>'admin.menu',
	         'url'=>'admin/menu',
	         'pre_id'=>'1',
	         'rank'=>'2',
	         'status'=>'1',
	         'display'=>'5',
	         'icon'=>'',
	         'created_at' => date('Y-m-d H:i:s',time()),
	         'updated_at' => date('Y-m-d H:i:s',time()),
         ]);
         DB::table('menues')->insert([
	         'name' => 'pages',
	         'access'=>'admin.pages',
	         'url'=>'admin/pages',
	         'pre_id'=>'1',
	         'rank'=>'2',
	         'status'=>'1',
	         'display'=>'5',
	         'icon'=>'',
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
        Schema::drop('menues');
    }
}
