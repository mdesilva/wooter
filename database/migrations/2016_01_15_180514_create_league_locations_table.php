<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_locations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->integer('location_id')->unsigned();
            $table->index('location_id');
            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->onDelete('cascade');

            $table->unique(['league_id', 'location_id']);

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
        Schema::drop('league_locations');
    }
}
