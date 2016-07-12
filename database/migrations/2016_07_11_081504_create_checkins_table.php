<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('placeId')->unsigned();
            $table->foreign('placeId')->references('id')->on('places')->onDelete('cascade');
            $table->integer('geoId')->unsigned();
            $table->foreign('geoId')->references('id')->on('geolocations')->onDelete('cascade');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('checkins');
    }
}
