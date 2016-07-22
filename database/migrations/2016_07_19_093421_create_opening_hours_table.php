<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpeningHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('placeId')->unsigned();
            $table->foreign('placeId')->references('id')->on('places')->onDelete('cascade');
            $table->integer('dayOfWeek')->unsigned();
            $table->string('hours',96);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opening_hours');
    }
}
