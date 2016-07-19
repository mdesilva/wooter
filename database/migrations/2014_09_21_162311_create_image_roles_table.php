<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Wooter\ImageRoles;

class CreateImageRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if(!Schema::hasTable('image_roles')){
            Schema::create('image_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });

            $types = ImageRoles::getImagesTypesOrganized();

            foreach ($types as $type){
                $save = new ImageRoles();

                $save->name = $type;

                $save->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('image_roles');
    }
}
