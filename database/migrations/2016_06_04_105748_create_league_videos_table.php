<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_videos', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->integer('video_id')->unsigned();
            $table->index('video_id');
            $table->foreign('video_id')
                ->references('id')->on('videos')
                ->onDelete('cascade');

            $table->integer('label_id')->unsigned()->nullable();
            $table->index('label_id');
            $table->foreign('label_id')
                ->references('id')->on('league_video_labels')
                ->onDelete('SET NULL');

            $table->integer('game_id')->unsigned()->nullable();
            $table->index('game_id');
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('SET NULL');
            $table->unique(['league_id', 'video_id', 'label_id', 'game_id']);

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
        Schema::drop('league_videos');
    }
}
