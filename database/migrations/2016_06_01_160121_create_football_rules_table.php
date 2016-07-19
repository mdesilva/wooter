<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFootballRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football_rules', function (Blueprint $table) {
            $table->increments('id');

            $table->tinyInteger('times')->unsigned();
            $table->tinyInteger('minutes_per_time')->unsigned();
            $table->decimal('points_per_win');
            $table->decimal('points_per_loss');
            $table->decimal('points_per_draw');

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
        Schema::drop('football_rules');
    }
}
