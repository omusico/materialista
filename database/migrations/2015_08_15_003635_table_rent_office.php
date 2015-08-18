<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRentOffice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_office', function(Blueprint $table){
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
            $table->string('floor_number');
            $table->string('door');
            $table->boolean('has_block');
            $table->string('block')->nullable();
            $table->string('residential_area')->nullable();

            /*
             * STEP 2
             */

            //apartment condition and size
            $table->boolean('needs_restoration');
            $table->integer('area_constructed',false,true);
            $table->integer('area_usable',false,true)->nullable();
            $table->integer('area_min_for_sale',false,true)->nullable();

            //floors and building info
            $table->integer('n_floors',false,true);
            $table->boolean('has_offices_only');

            //distribution
            $table->integer('office_distribution_id',false,true);
            $table->foreign('office_distribution_id')->references('id')->on('office_distribution')->onDelete('restrict')->onUpdate('cascade');

            //rooms
            $table->integer('n_restrooms',false,true);
            $table->boolean('has_bathrooms');
            $table->boolean('has_bathrooms_inside');

            //commodities
            $table->boolean('is_exterior');
            $table->integer('n_elevators',false,true);

            //energy certification
            $table->integer('energy_certification_id',false,true);
            $table->foreign('energy_certification_id')->references('id')->on('energy_certification')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('energy_performance',false,true)->nullable();

            //parking spaces
            $table->integer('n_parking_spaces',false,true);

            //security
            $table->boolean('has_steel_door');
            $table->boolean('has_security_system');
            $table->boolean('has_access_control');
            $table->boolean('has_fire_detectors');
            $table->boolean('has_fire_extinguishers');
            $table->boolean('has_fire_sprinklers');
            $table->boolean('has_fireproof_doors');
            $table->boolean('has_emergency_lights');
            $table->boolean('has_doorman');

            //others details (office)
            $table->boolean('has_air_conditioning_pre-installation');
            $table->boolean('has_air_conditioning');
            $table->boolean('has_heating');
            $table->boolean('has_hot_water');
            $table->boolean('has_kitchen');
            $table->boolean('has_archive');
            $table->boolean('has_double_windows');
            $table->boolean('has_suspended_ceiling');
            $table->boolean('has_suspended_floor');

            //others details (building)
            $table->boolean('is_handicapped_adapted');

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
        Schema::drop('rent_office');
    }
}
