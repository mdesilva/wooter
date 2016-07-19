<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamSoccerStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_soccer_stats', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('game_id')->unsigned();
            $table->index('game_id');
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');

            $table->integer('team_id')->unsigned();
            $table->index('team_id');
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');

            $table->integer('first_half_score');
            $table->integer('second_half_score');
            $table->integer('final_score');
            $table->tinyInteger('win');
            $table->tinyInteger('loss');
            $table->tinyInteger('draw');
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
        Schema::drop('team_soccer_stats');
    }
}
