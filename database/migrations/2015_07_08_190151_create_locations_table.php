<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PHONE_LOCATION', function (Blueprint $table) {
            $table->increments('PHONE_LOCATION_ID');
	    $table->string('PHONE_LOCATION_NAME');
	    $table->string('SERVER_IP');
	    $table->string('TFTP_DIRECTORY');
	    $table->string('NON_TFTP_DIRECTORY');
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
        Schema::drop('PHONE_LOCATION');
    }
}
