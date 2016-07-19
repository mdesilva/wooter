<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_competitions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('organization_id')->unsigned();
            $table->index('organization_id');
            $table->string('organization_type');

            $table->string('name');
            $table->timestamp('starts_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ends_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('registration_opens_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('registration_closes_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->smallInteger('max_teams')->unsigned()->nullable();
            $table->smallInteger('min_teams')->unsigned()->nullable();
            $table->smallInteger('max_free_agents')->unsigned()->nullable();
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
        Schema::drop('season_competitions');
    }
}
