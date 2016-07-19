<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerSoccerStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_soccer_stats', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('player_id')->unsigned();
            $table->index('player_id');
            $table->foreign('player_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('team_id')->unsigned();
            $table->index('team_id');
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');

            $table->integer('game_id')->unsigned();
            $table->index('game_id');
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');

            $table->string('jersey');
            $table->tinyInteger('minutes_played')->unsigned();
            $table->tinyInteger('passes')->unsigned();
            $table->tinyInteger('goals')->unsigned();
            $table->tinyInteger('yellow_cards')->unsigned();
            $table->tinyInteger('home_team_goals')->unsigned();
            $table->tinyInteger('faults')->unsigned();
            $table->tinyInteger('penalties')->unsigned();

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
        Schema::drop('player_soccer_stats');
    }
}
