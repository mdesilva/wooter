<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailboxTrash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailbox_trash'))
        {
            Schema::create('mailbox_trash', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('mailbox_id')->unsigned();
                $table->index('mailbox_id');
                $table->foreign('mailbox_id')
                    ->references('id')->on('mailboxes')
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
        Schema::drop('mailbox_trash');
    }
}