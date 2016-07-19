<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
    use Wooter\ImageRoles;

    class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('images')){
            Schema::create('images', function (Blueprint $table) {
                $table->increments('id');

                $table->string('file_name');
                $table->string('file_path');
                $table->string('thumbnail_path');
                $table->integer('size');
                $table->string('mime_type');
                $table->string('extension');

                $table->integer('role')->unsigned()->default(ImageRoles::IMAGE_HIDDEN_ID)->nullable();
                $table->index('role');
                $table->foreign('role')
                    ->references('id')->on('image_roles')
                    ->onDelete('SET NULL');

                $table->text('description');

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
        Schema::drop('images');
    }
}
