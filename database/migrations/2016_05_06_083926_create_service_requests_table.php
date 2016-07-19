<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->string('sport');
            $table->string('address_1');
            $table->string('address_2');
            $table->tinyInteger('type');
            $table->tinyInteger('number_of_teams');
            $table->tinyInteger('number_of_players');
            $table->tinyInteger('number_of_games_per_team');

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
        Schema::drop('service_requests');
    }
}
