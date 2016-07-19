<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_award', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('player_id')->unsigned();
            $table->index('player_id');
            $table->foreign('player_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('award_id')->unsigned();
            $table->index('award_id');
            $table->foreign('award_id')
                ->references('id')->on('awards')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['player_id', 'award_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('player_award');
    }
}
