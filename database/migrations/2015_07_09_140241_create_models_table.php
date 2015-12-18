<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PHONE_MODEL', function (Blueprint $table) {
            $table->increments('PHONE_MODEL_ID');
	    $table->string('MODEL_NAME');
	    $table->string('PSN');
	    $table->string('BRAND');
	    $table->smallInteger('USE_TFTP_DIR');
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
        Schema::drop('PHONE_MODEL');
    }
}
