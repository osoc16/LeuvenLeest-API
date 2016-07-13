<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('foursquareId',24)->unique()->nullable();
            $table->integer('geoId')->unsigned();
            $table->foreign('geoId')->references('id')->on('geolocations')->onDelete('cascade');
            $table->text('name');
            $table->text('address')->nullable();
            $table->longText('description')->nullable();
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->string('email')->nullable();
            $table->integer('categoryId')->unsigned();
            $table->foreign('categoryId')->references('id')->on('categories');
            $table->string('site')->nullable();
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
        Schema::drop('places');
    }
}
