<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('season_structures'))
        {
            Schema::create('season_structures', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('name_localized');
                $table->timestamps();
            });
            DB::table('season_structures')->insert([
                'name' => 'League play',
                'name_localized' => 'season-structures.league-play',
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
        Schema::drop('season_structures');
    }
}
