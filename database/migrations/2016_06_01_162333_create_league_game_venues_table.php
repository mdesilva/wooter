<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueGameVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_game_venues', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->integer('game_venue_id')->unsigned();
            $table->index('game_venue_id');
            $table->foreign('game_venue_id')
                ->references('id')->on('game_venues')
                ->onDelete('cascade');

            $table->unique(['league_id', 'game_venue_id']);

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
        Schema::drop('league_game_venues');
    }
}
