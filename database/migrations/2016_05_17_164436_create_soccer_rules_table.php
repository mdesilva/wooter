<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoccerRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soccer_rules', function (Blueprint $table) {
            $table->increments('id');

            $table->tinyInteger('times')->unsigned();
            $table->tinyInteger('minutes_per_time')->unsigned();
            $table->decimal('points_per_win');
            $table->decimal('points_per_loss');
            $table->decimal('points_per_draw');
            $table->boolean('penalty_when_match_ends_in_draw');
            $table->boolean('max_red_cards_per_team_per_match');
            $table->boolean('max_yellow_cards_per_team_per_match');

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
        Schema::drop('soccer_rules');
    }
}
