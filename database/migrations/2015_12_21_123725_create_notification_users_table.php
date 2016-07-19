<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('notification_id')->unsigned();
            $table->index('notification_id');
            $table->foreign('notification_id')
                ->references('id')->on('notifications')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->enum('read', ['0','1'])->default('0');

            $table->unique(['user_id', 'notification_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_users');
    }
}
