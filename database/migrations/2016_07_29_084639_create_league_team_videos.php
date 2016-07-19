<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueTeamVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('league_team_videos'))
        Schema::create('league_team_videos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_video_id')->unsigned();
            $table->index('league_video_id');
            $table->foreign('league_video_id')
                ->references('id')->on('league_videos')
                ->onDelete('cascade');

            $table->integer('team_id')->unsigned();
            $table->index('team_id');
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');

            $table->unique(['league_video_id', 'team_id']);

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
        Schema::drop('league_team_videos');
    }
}
