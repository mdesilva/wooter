<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueVideoLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_video_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label_name');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');
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
        Schema::drop('league_video_labels');
    }
}
