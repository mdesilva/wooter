<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->integer('sport_id')->unsigned()->nullable();
            $table->index('sport_id');
            $table->foreign('sport_id')
                ->references('id')->on('sports')
                ->onDelete('SET NULL');

            $table->integer('captain_id')->unsigned()->nullable()->nullable();
            $table->index('captain_id');
            $table->foreign('captain_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL');

            $table->integer('cover_photo_id')->unsigned()->nullable()->nullable();
            $table->index('cover_photo_id');
            $table->foreign('cover_photo_id')
                ->references('id')->on('images')
                ->onDelete('SET NULL');

            $table->integer('logo_id')->unsigned()->nullable()->nullable();
            $table->index('logo_id');
            $table->foreign('logo_id')
                ->references('id')->on('images')
                ->onDelete('SET NULL');

            $table->text('description')->nullable();

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
        Schema::drop('teams');
    }
}
