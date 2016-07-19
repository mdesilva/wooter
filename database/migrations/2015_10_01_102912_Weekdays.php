<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Weekdays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('weekdays'))
        {
            Schema::create('weekdays', function (Blueprint $table) {
                $table->increments('id');
                $table->string('day');
                $table->string('day_localized');
                $table->timestamps();
            });

            DB::table('weekdays')->insert([
                'day' => 'Monday',
                'day_localized' => 'time.weekdays.monday',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('weekdays')->insert([
                'day' => 'Tuesday',
                'day_localized' => 'time.weekdays.tuesday',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('weekdays')->insert([
                'day' => 'Wednesday',
                'day_localized' => 'time.weekdays.wednesday',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('weekdays')->insert([
                'day' => 'Thursday',
                'day_localized' => 'time.weekdays.thursday',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('weekdays')->insert([
                'day' => 'Friday',
                'day_localized' => 'time.weekdays.friday',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('weekdays')->insert([
                'day' => 'Saturday',
                'day_localized' => 'time.weekdays.saturday',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('weekdays')->insert([
                'day' => 'Sunday',
                'day_localized' => 'time.weekdays.sunday',
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
        Schema::drop('weekdays');
    }
}
