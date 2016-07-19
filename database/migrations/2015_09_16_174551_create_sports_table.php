<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sports'))
        {
            Schema::create('sports', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('name_localized');
                $table->timestamps();
            });

            $inserts = [];
            $sports = [
                'Soccer',
                'Basketball',
                'Hockey',
                'Football',
                'Tennis',
                'Baseball',
                'Kickball',
                'Softball',
                'Bowling',
                'Dodgeball',
                'Volleyball'
            ];

            foreach($sports as $sport){
                $inserts[] = [
                    'name' => $sport,
                    'name_localized' => 'sports.'.strtolower($sport),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ];
            }

            DB::table('sports')->insert($inserts);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sports');
    }
}
