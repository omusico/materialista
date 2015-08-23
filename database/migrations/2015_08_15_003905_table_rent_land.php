<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRentLand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_land', function(Blueprint $table){
            $table->increments('id');
            $table->integer('ad_id',false,true);
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('restrict')->onUpdate('cascade');

            /*
             *  STEP 1
             */

            //basic info
            $table->integer('price',false,true);
            $table->string('deposit')->nullable();

            //address
            $table->decimal('lat',9,7);
            $table->decimal('lng',9,7);
            $table->string('formatted_address',510);
            $table->integer('street_number',false,true);
            $table->string('route');
            $table->string('locality');
            $table->string('admin_area_lvl2'); //Provincia
            $table->string('admin_area_lvl1'); //Comunidad aut�noma
            $table->string('country');
            $table->string('postal_code');

            $table->boolean('hide_address');

            //other address details
            $table->string('residential_area')->nullable();

            /*
             * STEP 2
             */

            //land category
            $table->integer('category_land_id',false,true);
            $table->foreign('category_land_id')->references('id')->on('category_land')->onDelete('restrict')->onUpdate('cascade');

            //surface
            $table->integer('area_total',false,true);
            $table->integer('area_building_land',false,true);
            $table->integer('area_min_for_sale',false,true);

            //other classification details (land)
            $table->boolean('is_classified_residential_block');
            $table->boolean('is_classified_residential_house');
            $table->boolean('is_classified_office');
            $table->boolean('is_classified_commercial');
            $table->boolean('is_classified_hotel');
            $table->boolean('is_classified_industrial');
            $table->boolean('is_classified_public_service');
            $table->boolean('is_classified_others');

            //maximum floors allowed to be build
            $table->integer('max_floors_allowed',false,true);

            //road access
            $table->boolean('has_road_access');

            //distance to nearest town
            $table->integer('nearest_town_distance_id',false,true);
            $table->foreign('nearest_town_distance_id')->references('id')->on('nearest_town_distance')->onDelete('restrict')->onUpdate('cascade');

            //other (land)
            $table->boolean('has_water');
            $table->boolean('has_electricity');
            $table->boolean('has_sewer_system');
            $table->boolean('has_natural_gas');
            $table->boolean('has_street_lighting');
            $table->boolean('has_sidewalks');

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
        Schema::drop('rent_land');
    }
}
