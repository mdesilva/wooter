<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailboxBroadcasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailbox_broadcasts'))
        {
            Schema::create('mailbox_broadcasts', function (Blueprint $table) {
                $table->increments('id');
                
                $table->string('title');
                
                $table->string('message');
                
                $table->integer('user_id')->unsigned();
                $table->index('user_id');
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
                
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
        Schema::drop('mailbox_broadcasts');
    }
}
