<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_stages', function (Blueprint $table) {

            $table->integer('competition_id')->unsigned();
            $table->index('competition_id');

            $table->integer('stage_id')->unsigned();
            $table->index('stage_id');
            $table->string('stage_type');

            $table->unique(['competition_id', 'stage_id', 'stage_type']);

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
        Schema::drop('competition_stages');
    }
}
