<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PHONE_TEMPLATE', function (Blueprint $table) {
            $table->increments('PHONE_TEMPLATE_ID');
	    $table->string('DESCRIPTION');
	    $table->text('TEMPLATE');
	    $table->string('TEMPLATE_NAME');
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
        Schema::drop('PHONE_TEMPLATE');
    }
}
