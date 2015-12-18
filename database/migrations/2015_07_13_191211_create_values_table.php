<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PHONE_PARAMETER_VALUE', function (Blueprint $table) {
            $table->increments('PHONE_PARAMETER_ID');
	    $table->integer('PHONE_ID');
	    $table->integer('PARAMETER_ID');
	    $table->string('VALUE');
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
        Schema::drop('PHONE_PARAMETER_VALUE');
    }
}
