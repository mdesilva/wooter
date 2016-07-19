<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_weeks', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('stage_id')->unsigned();
            $table->index('stage_id');
            $table->string('stage_type');
            
            $table->string('name');
            
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');

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
        Schema::drop('competition_weeks');
    }
}
