<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeagueDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('league_details'))
        {
            Schema::create('league_details', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('league_id')->unsigned();
                $table->index('league_id');
                $table->foreign('league_id')
                    ->references('id')->on('league_organizations')
                    ->onDelete('cascade');

                $table->text('description');
                $table->smallInteger('number_of_teams')->unsigned();
                $table->smallInteger('players_per_team')->unsigned();
                $table->smallInteger('games_per_team')->unsigned();
                $table->smallInteger('max_players')->unsigned()->nullable();
                $table->smallInteger('game_duration')->unsigned();
                $table->smallInteger('time_period')->unsigned()->nullable();
                $table->timestamps();

                $table->unique('league_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('league_details');
    }
}
