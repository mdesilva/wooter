<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourtTimeSlots extends Migration
{
    
    /**********EXACT COPY OF LOCATIONS TABLE ON COURTS, IMPROVEMENTS COMING LATER**********/
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('court_time_slots', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('sr_no');
            
            $table->integer('court_id')->unsigned();
            $table->foreign('court_id')
                  ->references('id')->on('court_organizations')
                  ->onDelete('cascade');
            
            $table->string('monday');
            $table->string('tuesday');
            $table->string('wednesday');
            $table->string('thursday');
            $table->string('friday');
            $table->string('saturday');
            $table->string('sunday');
            $table->string('extended_dates');
            $table->string('manual_slots');
            
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
        Schema::drop('court_time_slots');
    }
}