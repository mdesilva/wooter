<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayoffStructures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('playoff_structures'))
        {
            Schema::create('playoff_structures', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('name_localized');
                $table->timestamps();
            });
            DB::table('playoff_structures')->insert([
                'name' => 'Single game elimination',
                'name_localized' => 'structures.playoffs.single_game_elimination',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('playoff_structures');
    }
}
