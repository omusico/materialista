<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRentBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_business', function(Blueprint $table){
            $table->increments('id');
            $table->integer('ad_id',false,true);
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('restrict')->onUpdate('cascade');

            /*
             *  STEP 1
             */

            //basic info
            $table->integer('price',false,true);
            $table->boolean('is_transfer');
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
            $table->string('floor_number');
            $table->string('door');
            $table->boolean('has_block');
            $table->string('block')->nullable();
            $table->string('residential_area')->nullable();

            /*
             * STEP 2
             */

            //country house category
            $table->integer('category_business_id',false,true);
            $table->foreign('category_business_id')->references('id')->on('category_business')->onDelete('restrict')->onUpdate('cascade');

            //business condition and size
            $table->boolean('needs_restoration');
            $table->integer('area_constructed',false,true);
            $table->integer('area_usable',false,true)->nullable();

            //space distribution
            $table->integer('business_distribution_id',false,true);
            $table->foreign('business_distribution_id')->references('id')->on('business_distribution')->onDelete('restrict')->onUpdate('cascade');

            //facade size
            $table->integer('business_facade_id',false,true);
            $table->foreign('business_facade_id')->references('id')->on('business_facade')->onDelete('restrict')->onUpdate('cascade');

            //shop windows
            $table->integer('n_shop_windows',false,true);

            //business location
            $table->integer('business_location_id',false,true);
            $table->foreign('business_location_id')->references('id')->on('business_location')->onDelete('restrict')->onUpdate('cascade');

            //floors and building info
            $table->integer('n_floors',false,true);

            //rooms
            $table->integer('n_restrooms',false,true);

            //last activity
            $table->string('last_activity');

            //energy certification
            $table->integer('energy_certification_id',false,true);
            $table->foreign('energy_certification_id')->references('id')->on('energy_certification')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('energy_performance',false,true)->nullable();

            //others details (business)
            $table->boolean('has_archive');
            $table->boolean('has_smoke_extractor');
            $table->boolean('has_fully_equipped_kitchen');
            $table->boolean('has_steel_door');
            $table->boolean('has_alarm');
            $table->boolean('has_air_conditioning');
            $table->boolean('has_heating');
            $table->boolean('has_security_camera');
            $table->boolean('is_corner_located');

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
        Schema::drop('rent_business');
    }
}
