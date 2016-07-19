<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerFootballReceiverStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('player_football_receiver_stats'))
        {
            Schema::create('player_football_receiver_stats', function (Blueprint $table) {
                $table->increments('id');
                
                $table->integer('player_id');
                
                $table->integer('team_id')->unsigned();
                $table->index('team_id');
                $table->foreign('team_id')
                    ->references('id')->on('teams')
                    ->onDelete('cascade');
                
                $table->integer('game_id')->unsigned();
                $table->index('game_id');
                $table->foreign('game_id')
                    ->references('id')->on('games')
                    ->onDelete('cascade');
                
                $table->string('name');
                $table->string('jersey');
                $table->tinyInteger('active');
                $table->integer('REC');
                $table->integer('YDS');
                $table->decimal('AVG', 10, 2);
                $table->integer('TD');
                $table->integer('LONG');
                $table->integer('TGTS');
                
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
        Schema::drop('player_football_receiver_stats');
    }
}
