<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->integer('image_id')->unsigned();
            $table->index('image_id');
            $table->foreign('image_id')
                ->references('id')->on('images')
                ->onDelete('cascade');

            $table->integer('album_id')->unsigned()->nullable();
            $table->index('album_id');
            $table->foreign('album_id')
                ->references('id')->on('league_photo_albums')
                ->onDelete('SET NULL');

            $table->integer('game_id')->unsigned()->nullable();
            $table->index('game_id');
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('SET NULL');

           $table->integer('division_id')->unsigned()->nullable();
            $table->index('division_id');
            $table->foreign('division_id')
                ->references('id')->on('divisions')
                ->onDelete('SET NULL');

            $table->unique(['league_id', 'image_id']);
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
        Schema::drop('league_photos');
    }
}
