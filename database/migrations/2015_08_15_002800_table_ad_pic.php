<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableAdPic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_pic', function(Blueprint $table){
            $table->increments('id');
            $table->string('filename');
            $table->integer('ad_id',false,true);
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('ad_pic');
    }
}
