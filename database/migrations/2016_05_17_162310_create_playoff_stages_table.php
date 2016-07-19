<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayoffStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playoff_stages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('competition_id')->unsigned();
            $table->index('competition_id');
            $table->string('competition_type');

            $table->integer('rule_id')->unsigned();
            $table->string('rule_type');

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->integer('competition_week_id')->unsigned()->nullable();
            $table->index('competition_week_id');
            $table->foreign('competition_week_id')
                ->references('id')->on('competition_weeks')
                ->onDelete('SET NULL');

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
        Schema::drop('playff_stages');
    }
}
