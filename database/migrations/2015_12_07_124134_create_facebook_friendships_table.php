<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_friendships', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_wooter_id')->unsigned();
            $table->index('user_wooter_id');
            $table->foreign('user_wooter_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->bigInteger('user_facebook_id')->unsigned();
            $table->index('user_facebook_id');

            $table->bigInteger('friend_facebook_id')->unsigned();
            $table->index('friend_facebook_id');

            $table->timestamps();

            $table->unique(['user_wooter_id', 'friend_facebook_id']);
            $table->unique(['user_facebook_id', 'friend_facebook_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facebook_friendships');
    }
}
