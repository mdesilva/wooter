<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->integer('size');
            $table->string('mime_type');
            $table->string('extension');
            $table->text('description');

            $table->string('youtube_src');
            $table->string('cdn_src');
            $table->string('video_hash');
            $table->integer('type')->default('1');

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
        Schema::drop('videos');
    }
}
