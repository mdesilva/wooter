<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Wooter\Commands\getCountriesCommand;
use Wooter\Country;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_localized')->nullable();
            $table->string('code');
            $table->timestamps();
        });

        $countries = dispatch(new getCountriesCommand());

        $inserts = [];
        foreach ($countries as $country){
            $inserts[] = [
                'name' => $country['name'],
                'code' => $country['code'],
                'name_localized' => 'countries' . str_slug($country['name']),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
        }

        DB::table('countries')->insert($inserts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries');
    }
}
