<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguePlayerPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('league_player_photos'))
        Schema::create('league_player_photos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_photo_id')->unsigned();
            $table->index('league_photo_id');
            $table->foreign('league_photo_id')
                ->references('id')->on('league_photos')
                ->onDelete('cascade');


            $table->integer('player_id')->unsigned();
            $table->index('player_id');
            $table->foreign('player_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unique([ 'league_photo_id', 'player_id']);


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
        Schema::drop('league_player_photos');
    }
}
