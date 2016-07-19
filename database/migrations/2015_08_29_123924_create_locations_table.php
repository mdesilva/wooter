<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('country_id')->unsigned();
            $table->index('country_id');
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('cascade');

            $table->integer('city_id')->unsigned();
            $table->index('city_id');
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('cascade');

            $table->string('name');
            $table->string('street');
            $table->string('flat')->nullable();
            $table->string('state');
            $table->string('zip');
            $table->string('full_address');
            $table->decimal('latitude', 10, 8); // -90:+90 - Latitude
            $table->decimal('longitude', 11, 8); // -180:+180 - Longitude

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
        Schema::drop('locations');
    }
}
