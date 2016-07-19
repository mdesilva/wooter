<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_prices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->decimal('price');
            $table->string('name');
            $table->string('description');
            $table->string('url')->nullable();

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
        Schema::drop('league_prices');
    }
}
