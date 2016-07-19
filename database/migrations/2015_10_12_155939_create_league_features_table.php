<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('league_features'))
        {
            Schema::create('league_features', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('league_id')->unsigned();
                $table->index('league_id');
                $table->foreign('league_id')
                    ->references('id')->on('league_organizations')
                    ->onDelete('cascade');

                $table->integer('feature_id')->unsigned();
                $table->index('feature_id');
                $table->foreign('feature_id')
                    ->references('id')->on('features')
                    ->onDelete('cascade');

                $table->timestamps();
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
        Schema::drop('league_features');
    }
}
