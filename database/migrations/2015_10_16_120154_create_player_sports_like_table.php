<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerSportsLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_sports_like', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('player_id')->unsigned();
            $table->index('player_id');
            $table->foreign('player_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('sport_like_id')->unsigned();
            $table->index('sport_like_id');
            $table->foreign('sport_like_id')
                ->references('id')->on('sports')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['player_id', 'sport_like_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('player_sports_like');
    }
}
