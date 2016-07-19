<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailboxConversationsContainers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailbox_conversations_containers'))
        {
            Schema::create('mailbox_conversations_containers', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('mailbox_conversation_id');
                
                $table->integer('container_id');
                
                $table->string('container_type');
                
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
        Schema::drop('mailbox_conversations_containers');
    }
}
