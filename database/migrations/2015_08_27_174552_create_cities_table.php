<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cities'))
        {
            Schema::create('cities', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('country_id')->unsigned();
                $table->index('country_id');
                $table->foreign('country_id')
                    ->references('id')->on('countries')
                    ->onDelete('cascade');

                $table->string('name');
                $table->string('name_localized');
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
        Schema::drop('cities');
    }
}
