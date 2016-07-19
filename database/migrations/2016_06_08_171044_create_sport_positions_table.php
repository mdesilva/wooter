<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_positions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sport_id')->unsigned();
            $table->index('sport_id');
            $table->foreign('sport_id')
                ->references('id')->on('sports')
                ->onDelete('cascade');

            $table->string('position');

            $table->timestamps();
        });
        
        $inserts = [];
        $positions = [
            ['all', 2],
            ['batter', 8],
            ['pitcher', 8],
            ['quarterback', 4],
            ['receiver', 4],
            ['defender', 4],
            ['rusher', 4]
        ];
        
        foreach ($positions as $position) {
            $inserts[] = [
                'sport_id' => $position[1],
                'position' => $position[0],
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
        }
        
        DB::table('sport_positions')->insert($inserts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sport_positions');
    }
}
