<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguePrivateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_private_invites', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('league_id')->unsigned();
            $table->index('league_id');
            $table->foreign('league_id')
                ->references('id')->on('league_organizations')
                ->onDelete('cascade');

            $table->string('email');
            $table->string('token');

            $table->enum('status', ['0','1'])->default('0');

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
        Schema::drop('league_private_invites');
    }
}
