<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_team_id')->unsigned();
            $table->index('home_team_id');
            $table->foreign('home_team_id')
                ->references('id')->on('teams')
                ->onDelete('CASCADE');

            $table->integer('visiting_team_id')->unsigned();
            $table->index('visiting_team_id');
            $table->foreign('visiting_team_id')
                ->references('id')->on('teams')
                ->onDelete('CASCADE');

            $table->integer('game_venue_id')->unsigned();
            $table->index('game_venue_id');
            $table->foreign('game_venue_id')
                ->references('id')->on('game_venues')
                ->onDelete('CASCADE');

            $table->integer('sport_id')->unsigned();
            $table->index('sport_id');
            $table->foreign('sport_id')
                ->references('id')->on('sports')
                ->onDelete('CASCADE');

            $table->integer('competition_week_id')->unsigned();
            $table->index('competition_week_id');
            $table->foreign('competition_week_id')
                ->references('id')->on('competition_weeks')
                ->onDelete('CASCADE');

            $table->integer('stage_id')->unsigned();
            $table->index('stage_id');
            $table->string('stage_type');

            $table->timestamp('time');

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
        Schema::drop('games');
    }
}
