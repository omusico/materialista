<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRentRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_room', function(Blueprint $table){
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
            $table->integer('category_room_id',false,true);
            $table->foreign('category_room_id')->references('id')->on('category_room')->onDelete('restrict')->onUpdate('cascade');

            //room size
            $table->integer('area_room',false,true);

            //number of people in the house/apartment
            $table->integer('n_people',false,true);

            //rooms
            $table->integer('n_bedrooms',false,true);
            $table->integer('n_bathrooms',false,true);

            //current tenants info, house/apartment rules...
            $table->integer('current_tenants_gender_id',false,true);
            $table->foreign('current_tenants_gender_id')->references('id')->on('current_tenants_gender')->onDelete('restrict')->onUpdate('cascade');
            $table->boolean('is_smoking_allowed');
            $table->boolean('is_pet_allowed');
            $table->integer('min_current_tenants_age',false,true);
            $table->integer('max_current_tenants_age',false,true);
            $table->boolean('has_elevator');

            //other details (room)
            $table->boolean('has_furniture');
            $table->boolean('has_builtin_closets');

            //other details (house/apartment...)
            $table->boolean('has_air_conditioning');
            $table->boolean('has_internet');
            $table->boolean('has_house_keeper');

            //new tenant details
            $table->integer('tenant_gender_id',false,true);
            $table->foreign('tenant_gender_id')->references('id')->on('tenant_gender')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('tenant_occupation_id',false,true);
            $table->foreign('tenant_occupation_id')->references('id')->on('tenant_occupation')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('tenant_sexual_orientation_id',false,true);
            $table->foreign('tenant_sexual_orientation_id')->references('id')->on('tenant_sexual_orientation')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('tenant_min_stay_id',false,true);
            $table->foreign('tenant_min_stay_id')->references('id')->on('tenant_min_stay')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::drop('rent_room');
    }
}
