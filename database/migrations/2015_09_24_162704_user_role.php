<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_role'))
        {   
            Schema::create('user_role', function (Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->index('user_id');
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

                $table->integer('role_id')->unsigned();
                $table->index('role_id');
                $table->foreign('role_id')
                    ->references('id')->on('roles')
                    ->onDelete('cascade');

                $table->timestamps();

                $table->unique(['user_id', 'role_id']);
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
        Schema::drop('user_role');
    }
}
