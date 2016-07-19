<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourtOrganizationsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('court_organizations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->integer('entry');
            $table->timestamp('modef');
            $table->enum('status', ['0','1','2','3'])->default(3);
            $table->enum('verified', ['0','1'])->default(0);
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('google')->nullable();
            $table->string('phone', 50);
            $table->boolean('active')->default(true);

            $table->integer('sr_no');
            $table->string('city');
            $table->string('state');
            $table->string('lat');
            $table->string('lng');
            $table->string('title');
            $table->string('time');
            $table->integer('zip');
            $table->string('address');
            $table->string('court_or_field');
            $table->string('court_or_field_type');
            $table->string('work_week');
            $table->string('price');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('court_privacy_type');
            $table->string('duration');
            $table->integer('basket_rating');
            $table->integer('court_rating');
            $table->integer('size_rating');
            $table->integer('other_rating');
            $table->integer('total_rating');
            $table->string('neighborhood');
            
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
        Schema::drop('courts');
    }
}