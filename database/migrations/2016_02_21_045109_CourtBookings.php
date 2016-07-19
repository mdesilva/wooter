<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourtBookings extends Migration
{
    
    /**********EXACT COPY OF LOCATIONS TABLE ON COURTS, IMPROVEMENTS COMING LATER**********/
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('court_bookings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('sr_no');
            
            $table->integer('court_id')->unsigned();
            $table->foreign('court_id')
                  ->references('id')->on('court_organizations')
                  ->onDelete('cascade');
            
            $table->string('date');
            $table->string('time_slot');
            $table->string('date_of_booking');
            $table->string('start_time');
            $table->string('end_time');
            
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
        Schema::drop('court_bookings');
    }
}