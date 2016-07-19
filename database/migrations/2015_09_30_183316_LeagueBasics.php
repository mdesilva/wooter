<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LeagueBasics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('league_basics')) {
            Schema::create('league_basics', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('league_id')->unsigned();
                $table->index('league_id');
                $table->foreign('league_id')
                    ->references('id')->on('league_organizations')
                    ->onDelete('cascade');

                $table->integer('logo_id')->unsigned()->nullable();
                $table->index('logo_id');
                $table->foreign('logo_id')
                    ->references('id')->on('images')
                    ->onDelete('SET NULL');

                $table->tinyInteger('min_age')->unsigned();
                $table->tinyInteger('max_age')->unsigned();
                $table->enum('gender', ['male', 'female', 'other']);
                $table->timestamps();

                $table->unique('league_id');
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
        Schema::drop('league_basics');
    }
}
