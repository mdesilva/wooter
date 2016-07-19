<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Wooter\Currency;

class Currencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('currencies')) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('name_localized');
                $table->string('symbol');
                $table->timestamps();
            });

            $currencies = [
                [
                    'name' => 'Dollar',
                    'name_localized' => 'currencies.dollar',
                    'symbol' => '$'
                ],
                [
                    'name' => 'Euro',
                    'name_localized' => 'currencies.euro',
                    'symbol' => '€'
                ],
                [
                    'name' => 'Ruble',
                    'name_localized' => 'currencies.ruble',
                    'symbol' => '₽',
                ]
            ];

            foreach ($currencies as $currency){
                $save = new Currency();

                $save->name = $currency['name'];
                $save->name_localized = $currency['name_localized'];
                $save->symbol = $currency['symbol'];

                $save->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('currencies');
    }
}
