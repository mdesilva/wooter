<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_team', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('player_id')->unsigned();
            $table->index('player_id');
            $table->foreign('player_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('team_id')->unsigned();
            $table->index('team_id');
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');

            $table->integer('stage_id');
            $table->string('stage_type');
            
            $table->string('jersey');

            $table->timestamp('joined_at');

            $table->unique(['player_id', 'team_id', 'stage_id', 'stage_type']);

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
        Schema::drop('player_team');
    }
}
