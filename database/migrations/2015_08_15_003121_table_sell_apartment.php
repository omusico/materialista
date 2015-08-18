<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSellApartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_apartment', function(Blueprint $table){
            $table->increments('id');
            $table->integer('ad_id',false,true);
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('restrict')->onUpdate('cascade');

            /*
             *  STEP 1
             */

            //basic info
            $table->integer('price',false,true);
            $table->integer('community_cost',false,true)->nullable();

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
            $table->boolean('is_last_floor');
            $table->string('door');
            $table->boolean('has_block');
            $table->string('block')->nullable();
            $table->string('residential_area')->nullable();

            /*
             * STEP 2
             */

            //apartment category
            $table->boolean('is_regular');
            $table->boolean('is_penthouse');
            $table->boolean('is_duplex');
            $table->boolean('is_studio');

            //apartment condition and size
            $table->boolean('needs_restoration');
            $table->integer('area_constructed',false,true);
            $table->integer('area_usable',false,true)->nullable();

            //rooms
            $table->integer('n_bedrooms',false,true);
            $table->integer('n_bathrooms',false,true);

            //commodities
            $table->boolean('is_exterior');
            $table->boolean('has_elevator');

            //energy certification
            $table->integer('energy_certification_id',false,true);
            $table->foreign('energy_certification_id')->references('id')->on('energy_certification')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('energy_performance',false,true)->nullable();

            //orientation
            $table->boolean('faces_north');
            $table->boolean('faces_south');
            $table->boolean('faces_east');
            $table->boolean('faces_west');

            //other details (apartment)
            $table->boolean('has_builtin_closets');
            $table->boolean('has_air_conditioning');
            $table->boolean('has_terrace');
            $table->boolean('has_box_room');
            $table->boolean('has_parking_space');

            //other details (building)
            $table->boolean('has_swimming_pool');
            $table->boolean('has_garden');

            //description, other information
            $table->string('description',5000);

            /*
             * Timestamps
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
        Schema::drop('sell_apartment');
    }
}
