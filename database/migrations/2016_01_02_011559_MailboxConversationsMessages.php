<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailboxConversationsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailbox_conversations_messages'))
        {
            Schema::create('mailbox_conversations_messages', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('conversation_id')->unsigned();
                $table->index('conversation_id');
                $table->foreign('conversation_id')
                    ->references('id')->on('mailbox_conversations')
                    ->onDelete('cascade');
                
                $table->integer('user_id')->unsigned();
                $table->index('user_id');
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
                
                $table->string('message');
                
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
        Schema::drop('mailbox_conversations_messages');
    }
}