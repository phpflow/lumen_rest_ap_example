<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserViewDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_view_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('view_id')->unsigned();
			$table->string('service_name');
			$table->string('created_by');
			$table->string('updated_by');
            $table->timestamps();
        });
		Schema::table('user_view_details', function($table) {
		   $table->foreign('view_id')->references('id')->on('user_views');
	   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_view_details');
    }
}
