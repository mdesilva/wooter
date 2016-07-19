<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamBasketballStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_basketball_stats', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('team_id')->unsigned();
            $table->index('team_id');
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');

            $table->integer('game_id')->unsigned();
            $table->index('game_id');
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');
            
            $table->integer('first_quarter_score')->default(0);
            $table->integer('second_quarter_score')->default(0);
            $table->integer('third_quarter_score')->default(0);
            $table->integer('fourth_quarter_score')->default(0);
            $table->integer('final_score')->default(0);
            $table->tinyInteger('win')->default(0);
            $table->tinyInteger('loss')->default(0);
            $table->tinyInteger('draw')->default(0);

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
        Schema::drop('team_basketball_stats');
    }
}
