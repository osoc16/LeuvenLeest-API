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
            $table->integer('userId')->unsigned()->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('set null');
            $table->string('email')->nullable();
            $table->integer('categoryId')->unsigned()->nullable();
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('set null');
            $table->string('site')->nullable();
            $table->integer('photoId')->unsigned();
            $table->foreign('photoId')->references('id')->on('photos')->onDelete('cascade');
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
