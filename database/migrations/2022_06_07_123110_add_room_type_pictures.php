<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomTypePictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('room_types',function(Blueprint $table){

            $table->longText('picture')->comment('the picture file path')
            ->after('description')->nullable();


        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('room_type',function(Blueprint $table){

        $table->dropColumn('picture');

       });
    }
}
