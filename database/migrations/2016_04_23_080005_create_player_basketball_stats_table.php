<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerBasketballStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('player_basketball_stats'))
        {
            Schema::create('player_basketball_stats', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('player_id');
                
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

                $table->string('name');
                $table->string('jersey');
                $table->tinyInteger('active');
                $table->time('minutes_played');
                $table->tinyInteger('points')->unsigned();
                $table->tinyInteger('field_goals_made')->unsigned();
                $table->tinyInteger('field_goals_attempted')->unsigned();
                $table->tinyInteger('3_points_shots_made')->unsigned();
                $table->tinyInteger('3_points_shots_attempted')->unsigned();
                $table->tinyInteger('free_throws_made')->unsigned();
                $table->tinyInteger('free_throws_attempted')->unsigned();
                $table->tinyInteger('offensive_rebounds')->unsigned();
                $table->tinyInteger('defensive_rebounds')->unsigned();
                $table->tinyInteger('assists')->unsigned();
                $table->tinyInteger('turnovers')->unsigned();
                $table->tinyInteger('steals')->unsigned();
                $table->tinyInteger('blocked_shots')->unsigned();
                $table->tinyInteger('personal_fouls')->unsigned();

                $table->timestamps();
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
        Schema::drop('player_basketball_stats');
    }
}