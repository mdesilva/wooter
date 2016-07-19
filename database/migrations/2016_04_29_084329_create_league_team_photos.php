<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueTeamPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('league_team_photos'))
        Schema::create('league_team_photos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_photo_id')->unsigned();
            $table->index('league_photo_id');
            $table->foreign('league_photo_id')
                ->references('id')->on('league_photos')
                ->onDelete('cascade');


            $table->integer('team_id')->unsigned();
            $table->index('team_id');
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');


            $table->unique(['league_photo_id', 'team_id']);

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
        Schema::drop('league_team_photos');
    }
}
