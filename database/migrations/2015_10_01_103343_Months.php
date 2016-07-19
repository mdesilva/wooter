<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Months extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('months'))
        {
            Schema::create('months', function (Blueprint $table) {
                $table->increments('id');
                $table->string('month');
                $table->string('month_localized');
                $table->timestamps();
            });

            DB::table('months')->insert([
                'month' => 'January',
                'month_localized' => 'time.months.january',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'February',
                'month_localized' => 'time.months.february',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'March',
                'month_localized' => 'time.months.march',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'April',
                'month_localized' => 'time.months.april',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'May',
                'month_localized' => 'time.months.may',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'June',
                'month_localized' => 'time.months.june',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'Jule',
                'month_localized' => 'time.months.jule',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'August',
                'month_localized' => 'time.months.august',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'September',
                'month_localized' => 'time.months.september',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'October',
                'month_localized' => 'time.months.october',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'November',
                'month_localized' => 'time.months.november',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('months')->insert([
                'month' => 'December',
                'month_localized' => 'time.months.december',
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
        Schema::drop('months');
    }
}
