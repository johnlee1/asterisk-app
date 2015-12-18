<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PHONE', function (Blueprint $table) {
            $table->increments('PHONE_ID');
	    $table->integer('PHONE_TEMPLATE_ID');
	    $table->string('DESCRIPTION');
	    $table->integer('PHONE_LOCATION_ID');
	    $table->string('MAC');
	    $table->integer('PHONE_MODEL_ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('PHONE');
    }
}
