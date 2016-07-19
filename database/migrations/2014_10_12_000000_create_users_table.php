<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Wooter\Language;
use Wooter\Role;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->string('phone', 30)->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->string('school', 60)->nullable();
            $table->string('state', 60)->nullable();
            $table->string('city', 60)->nullable();
            $table->boolean('active')->default(true);
            $table->enum('verified', ['0','1'])->default('0');
            $table->enum('facebook_integrated', ['0','1'])->default('0');
            $table->enum('gender', ['male','female','other'])->default('male');
            $table->timestamp('birthday')->nullable();
            $table->tinyInteger('preselected_role')->default(Role::ATHLETE);
            $table->bigInteger('facebook_id')->unsigned()->default(0);

            $table->integer('picture_id')->unsigned()->nullable();
            $table->index('picture_id');
            $table->foreign('picture_id')
                ->references('id')->on('images')
                ->onDelete('SET NULL');

            $table->integer('language_id')->unsigned()->default(Language::ENGLISH)->nullable();
            $table->index('language_id');
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('SET NULL');

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
