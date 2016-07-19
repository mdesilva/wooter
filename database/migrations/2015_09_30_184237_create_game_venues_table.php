<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('game_venues'))
        {
            Schema::create('game_venues', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('location_id')->unsigned();
                $table->index('location_id');
                $table->foreign('location_id')
                    ->references('id')->on('locations')
                    ->onDelete('cascade');

                $table->string('court_name')->nullable();
                $table->tinyInteger('number_of_courts');

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
        Schema::drop('game_venues');
    }
}
