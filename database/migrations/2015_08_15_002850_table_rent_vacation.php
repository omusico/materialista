<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRentVacation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_vacation', function(Blueprint $table){
            $table->increments('id');
            $table->integer('ad_id',false,true);
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('restrict')->onUpdate('cascade');

            /*
             *  STEP 1
             */

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

            //category of the surroundings
            $table->integer('surroundings_id',false,true);
            $table->foreign('surroundings_id')->references('id')->on('surroundings')->onDelete('restrict')->onUpdate('cascade');

            //category of the rented place
            $table->integer('category_lodging_id',false,true);
            $table->foreign('category_lodging_id')->references('id')->on('category_lodging')->onDelete('restrict')->onUpdate('cascade');

            //multiple lodgings in the same address?
            $table->boolean('has_multiple_lodgings');

            //lodge size
            $table->integer('area_total',false,true)->nullable();;
            $table->integer('area_garden',false,true)->nullable();;
            $table->integer('area_terrace',false,true)->nullable();

            //kitchen typology
            $table->boolean('is_american_kitchen');

            //distances to common services
            $table->integer('distance_to_beach',false,true)->nullable();
            $table->integer('distance_to_town_center',false,true)->nullable();
            $table->integer('distance_to_ski_area',false,true)->nullable();
            $table->integer('distance_to_golf_course',false,true)->nullable();
            $table->integer('distance_to_airport',false,true)->nullable();
            $table->integer('distance_to_supermarket',false,true)->nullable();

            //distance to secondary services
            $table->integer('distance_to_river_or_lake',false,true)->nullable();
            $table->integer('distance_to_marina',false,true)->nullable();
            $table->integer('distance_to_horse_riding_area',false,true)->nullable();
            $table->integer('distance_to_scuba_diving_area',false,true)->nullable();
            $table->integer('distance_to_train_station',false,true)->nullable();
            $table->integer('distance_to_bus_station',false,true)->nullable();
            $table->integer('distance_to_hospital',false,true)->nullable();
            $table->integer('distance_to_hiking_area',false,true)->nullable();

            //rooms (+ min capacity), default: 0
            $table->integer('n_double_bedroom',false,true); //+2 min capacity (matrimonio)
            $table->integer('n_two_beds_room',false,true); //+2
            $table->integer('n_single_bed_room',false,true); //+1
            $table->integer('n_three_beds_room',false,true); //+3
            $table->integer('n_four_beds_room',false,true); //+4

            //extra beds (+ max capacity), default: 0
            $table->integer('n_sofa_bed',false,true); //+1 max capacity
            $table->integer('n_double_sofa_bed',false,true); //+2
            $table->integer('n_extra_bed',false,true); //+1

            //capacity (pre-calculated as suggestion in front-end, allow edit)
            $table->integer('min_capacity',false,true);
            $table->integer('max_capacity',false,true);

            //pricing information and price-included commodities
            $table->boolean('has_booking');
            $table->integer('booking',false,true)->nullable();
            $table->boolean('has_deposit');
            $table->string('deposit')->nullable();
            $table->integer('payment_day_id',false,true);
            $table->foreign('payment_day_id')->references('id')->on('payment_day')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('n_days_before',false,true)->nullable();
            $table->boolean('has_cleaning');
            $table->integer('cleaning',false,true)->nullable();
            $table->boolean('has_included_towels');
            $table->boolean('has_included_expenses');

            //accepted payment methods
            $table->boolean('accepts_cash');
            $table->boolean('accepts_transfer');
            $table->boolean('accepts_credit_card');
            $table->boolean('accepts_paypal');
            $table->boolean('accepts_check');
            $table->boolean('accepts_western_union');
            $table->boolean('accepts_money_gram');

            //exterior details
            $table->boolean('has_barbecue');
            $table->boolean('has_terrace');
            $table->boolean('has_private_swimming_pool');
            $table->boolean('has_shared_swimming_pool');
            $table->boolean('has_indoor_swimming_pool');
            $table->boolean('has_private_garden');
            $table->boolean('has_shared_garden');
            $table->boolean('has_furnished_garden');
            $table->boolean('has_parking_space');
            $table->boolean('has_playground');
            $table->boolean('has_mountain_sights');
            $table->boolean('has_sea_sights');

            //interior details
            $table->boolean('has_fireplace');
            $table->boolean('has_air_conditioning');
            $table->boolean('has_jacuzzi');
            $table->boolean('has_tv');
            $table->boolean('has_cable_tv');
            $table->boolean('has_internet');
            $table->boolean('has_heating');
            $table->boolean('has_fan');
            $table->boolean('has_cradle');
            $table->boolean('has_hairdryer');

            //kitchen details
            $table->boolean('has_dishwasher');
            $table->boolean('has_fridge');
            $table->boolean('has_oven');
            $table->boolean('has_microwave');
            $table->boolean('has_coffee_maker');

            //cloth related details
            $table->boolean('has_dryer');
            $table->boolean('has_washer');
            $table->boolean('has_iron');

            //other details
            $table->boolean('is_smoking_allowed');
            $table->boolean('is_pet_allowed');
            $table->boolean('has_elevator');
            $table->boolean('is_car_recommended');
            $table->boolean('is_handicapped_adapted');

            //surroundings
            $table->boolean('is_out_town_center');
            $table->boolean('is_isolated');
            $table->boolean('is_nudist_area');
            $table->boolean('is_bar_area');
            $table->boolean('is_gayfriendly_area');
            $table->boolean('is_family_tourism_area');
            $table->boolean('is_luxury_area');
            $table->boolean('is_charming');

            //services
            $table->boolean('has_bicycle_rental');
            $table->boolean('has_car_rental');
            $table->boolean('has_adventure_activities');
            $table->boolean('has_kindergarten');
            $table->boolean('has_sauna');
            $table->boolean('has_tennis_court');
            $table->boolean('has_paddle_court');
            $table->boolean('has_gym');

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
        Schema::drop('rent_vacation');
    }
}
