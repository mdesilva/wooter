<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamFootballStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_football_stats', function (Blueprint $table) {
            $table->increments('id');

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
            
            $table->integer('first_quarter_score');
            $table->integer('second_quarter_score');
            $table->integer('third_quarter_score');
            $table->integer('fourth_quarter_score');
            $table->integer('final_score');
            $table->tinyInteger('win');
            $table->tinyInteger('loss');
            $table->tinyInteger('draw');

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
        Schema::drop('team_football_stats');
    }
}
