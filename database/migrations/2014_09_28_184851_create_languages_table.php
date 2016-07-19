<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Wooter\Language;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('name_located');
            $table->string('code');

            $table->timestamps();
        });

        DB::table('languages')->insert([
            'name' => Language::ENGLISH_NAME,
            'name_located' => Language::ENGLISH_NAME_LOCATED,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('languages')->insert([
            'name' => Language::SPANISH_NAME,
            'name_located' => Language::SPANISH_NAME_LOCATED,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('languages')->insert([
            'name' => Language::RUSSIAN_NAME,
            'name_located' => Language::RUSSIAN_NAME_LOCATED,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('languages')->insert([
            'name' => Language::ROMANIAN_NAME,
            'name_located' => Language::ROMANIAN_NAME_LOCATED,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('languages');
    }
}
