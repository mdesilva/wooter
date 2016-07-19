<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_reviews', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('reviewer_id')->unsigned();
            $table->index('reviewer_id');
            $table->foreign('reviewer_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->text('review');
            $table->tinyInteger('stars');

            $table->boolean('verified');

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
        Schema::drop('league_reviews');
    }
}
