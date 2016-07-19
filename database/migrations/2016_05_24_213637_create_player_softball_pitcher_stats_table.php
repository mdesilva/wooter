<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerSoftballPitcherStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('player_softball_pitcher_stats'))
        {
            Schema::create('player_softball_pitcher_stats', function (Blueprint $table) {
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
                $table->decimal('IP');
                $table->integer('H');
                $table->integer('R');
                $table->integer('ERR');
                $table->integer('BB');
                $table->integer('SO');
                $table->integer('HR');
                $table->integer('PC');
                $table->integer('ST');
                $table->decimal('ERA', 10, 2);
                
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
        Schema::drop('player_softball_pitcher_stats');
    }
}
