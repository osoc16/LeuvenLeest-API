<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('placeId')->unsigned();
            $table->foreign('placeId')->references('Id')->on('places')->onDelete('cascade');
            $table->integer('questionId')->unsigned();
            $table->foreign('questionId')->references('Id')->on('questions')->onDelete('cascade');
            $table->integer('ratingGood');
            $table->integer('ratingBad');
            $table->integer('votes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evaluations');
    }
}
