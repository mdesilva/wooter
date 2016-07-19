<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailboxConversationsParticipantsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailbox_conversations_participants_status'))
        {
            Schema::create('mailbox_conversations_participants_status', function (Blueprint $table) {
                
                $table->increments('id');
                
                $table->integer('user_id')->unsigned();
                $table->index('user_id');
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
                
                $table->string('status');
                
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
        Schema::drop('mailbox_conversations_participants_status');
    }
}
