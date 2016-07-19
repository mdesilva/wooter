<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_requests', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->string('sport');
            $table->tinyInteger('package_type');
            $table->tinyInteger('number_of_teams');
            $table->tinyInteger('number_of_players');
            $table->tinyInteger('number_of_games_per_team');

            $table->boolean('full_game_footage')->default(false);
            $table->boolean('game_highlights')->default(false);
            $table->boolean('statistics')->default(false);
            $table->boolean('pro_videography')->default(false);
            $table->boolean('top_10')->default(false);
            $table->boolean('weekly_recap')->default(false);
            $table->boolean('player_photos')->default(false);
            $table->boolean('team_photos')->default(false);
            $table->boolean('promo_video')->default(false);
            $table->boolean('media_coverage')->default(false);
            $table->boolean('blog_exposure')->default(false);

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
        Schema::drop('package_requests');
    }
}
