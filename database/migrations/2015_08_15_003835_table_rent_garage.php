<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRentGarage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_garage', function(Blueprint $table){
            $table->increments('id');
            $table->integer('ad_id',false,true);
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('restrict')->onUpdate('cascade');

            /*
             *  STEP 1
             */

            //basic info
            $table->integer('price',false,true);
            $table->integer('deposit',false,true)->nullable();

            //address
            $table->decimal('lat',9,7);
            $table->decimal('lng',9,7);
            $table->string('formatted_address',510);
            $table->integer('street_number',false,true);
            $table->string('route');
            $table->string('locality');
            $table->string('admin_area_lvl2'); //Provincia
            $table->string('admin_area_lvl1'); //Comunidad autónoma
            $table->string('country');
            $table->string('postal_code');

            $table->boolean('hide_address');

            //other address details
            $table->string('residential_area')->nullable();

            /*
             * STEP 2
             */

            //capacity
            $table->integer('garage_capacity_id',false,true);
            $table->foreign('garage_capacity_id')->references('id')->on('garage_capacity')->onDelete('restrict')->onUpdate('cascade');

            //others details (garage)
            $table->boolean('is_covered');
            $table->boolean('has_automatic_door');
            $table->boolean('has_lift');
            $table->boolean('has_alarm');
            $table->boolean('has_security_camera');
            $table->boolean('has_security_guard');

            //description, other information
            $table->string('description',5000);

            /*
             * TIMESTAMPS
             */

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rent_garage');
    }
}
