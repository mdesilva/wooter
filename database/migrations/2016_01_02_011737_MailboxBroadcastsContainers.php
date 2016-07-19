<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailboxBroadcastsContainers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mailbox_broadcasts_containers'))
        {
            Schema::create('mailbox_broadcasts_containers', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('mailbox_broadcast_id');
                
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
        Schema::drop('mailbox_broadcasts_containers');
    }
}