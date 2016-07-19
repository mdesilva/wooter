<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->tinyInteger('type');
            $table->tinyInteger('permission');

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
        Schema::drop('league_permissions');
    }
}
