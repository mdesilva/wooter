<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_position', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('position_id')->unsigned();
            $table->index('position_id');
            $table->foreign('position_id')
                ->references('id')->on('sport_positions')
                ->onDelete('cascade');

            $table->integer('player_team_id')->unsigned();
            $table->index('player_team_id');
            $table->foreign('player_team_id')
                ->references('id')->on('player_team')
                ->onDelete('cascade');

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
        Schema::drop('player_position');
    }
}

