<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mailboxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailboxes'))
        {
            Schema::create('mailboxes', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('owner_id')->unsigned();
                
                $table->string('owner_type');
                
                $table->timestamps();
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mailboxes');
    }
}