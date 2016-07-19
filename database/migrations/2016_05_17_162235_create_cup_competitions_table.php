<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cup_competitions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('organization_id')->unsigned();
            $table->index('organization_id');
            $table->string('organization_type');

            $table->integer('sport_id')->unsigned()->nullable();
            $table->index('sport_id');
            $table->foreign('sport_id')
                ->references('id')->on('sports')
                ->onDelete('SET NULL');

            $table->string('name');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('registration_opens_at');
            $table->timestamp('registration_closes_at');
            $table->smallInteger('max_teams')->unsigned()->nullable();
            $table->smallInteger('max_free_agents')->unsigned()->nullable();
            $table->smallInteger('min_teams')->unsigned()->nullable();
            $table->smallInteger('min_free_agents')->unsigned()->nullable();
            $table->decimal('price');

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
        Schema::drop('cup_competitions');
    }
}
