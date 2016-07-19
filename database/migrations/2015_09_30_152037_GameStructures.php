<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameStructures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('game_structures'))
        {
            Schema::create('game_structures', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('name_localized');
                $table->timestamps();
            });
            DB::table('game_structures')->insert([
                'name' => 'Quarters',
                'name_localized' => 'structures.games.quarters',
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
        Schema::drop('game_structures');
    }
}
