<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegularStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regular_stages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('competition_id')->unsigned();
            $table->index('competition_id');
            $table->string('competition_type');

            $table->integer('rule_id')->unsigned()->nullable();
            $table->string('rule_type')->nullable();

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

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
        Schema::drop('regular_stages');
    }
}
