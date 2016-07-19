<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguePlayerVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('league_player_videos'))
        Schema::create('league_player_videos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_video_id')->unsigned();
            $table->index('league_video_id');
            $table->foreign('league_video_id')
                ->references('id')->on('league_videos')
                ->onDelete('cascade');


            $table->integer('player_id')->unsigned();
            $table->index('player_id');
            $table->foreign('player_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unique([ 'league_video_id', 'player_id']);

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
        Schema::drop('league_player_videos');
    }
}
