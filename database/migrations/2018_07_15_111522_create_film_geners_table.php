<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmGenersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_genres', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('film_id')->unsigned();
            $table->integer('genre_id')->unsigned();

            $table->foreign('film_id')->references('id')->on('films');
            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('film_genres');
    }
}
