<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_competitions', function (Blueprint $table) {

            $table->integer('organization_id')->unsigned();
            $table->index('organization_id');

            $table->integer('competition_id')->unsigned();
            $table->index('competition_id');
            $table->string('competition_type');

            $table->unique(['organization_id', 'competition_id', 'competition_type'], 'organization_competition_unique');

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
        Schema::drop('organization_competitions');
    }
}
