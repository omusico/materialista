<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableVacationSeasonPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_season_price', function(Blueprint $table){
            $table->increments('id');

            //inner counter
            $table->integer('n_season',false,true);

            //dates
            $table->date('from_date');
            $table->date('to_date');

            //prices
            $table->integer('p_one_night',false,true);
            $table->integer('p_weekend_night',false,true);
            $table->integer('p_one_week',false,true);
            $table->integer('p_half_month',false,true);
            $table->integer('p_one_month',false,true);
            $table->integer('p_extra_guest_per_night',false,true);

            //min number of nights
            $table->integer('n_min_nights',false,true);

            //vacation
            $table->integer('rent_vacation_id',false,true);
            $table->foreign('rent_vacation_id')->references('id')->on('rent_vacation')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::drop('vacation_season_price');
    }
}
