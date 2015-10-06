<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableGlobalCmsConstants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_cms_constants', function(Blueprint $table){
            $table->increments('id');

            //cms options (DEV only)
            $table->integer('n_ad_seeds',false,true)->default(0);
            $table->integer('starting_year',false,true)->default(2015);
            $table->string('dev_version')->default('1.0');
            $table->string('dev_email')->default('dev@materialista.com');

            //company options
            $table->string('company_name')->default('Materialista');
            $table->string('company_description')->default('Oferta inmobiliaria');
            $table->string('public_logo')->nullable();
            $table->integer('pl_height',false,true)->nullable();
            $table->integer('pl_width',false,true)->nullable();
            $table->string('dashboard_logo')->nullable();
            $table->integer('dl_height',false,true)->nullable();
            $table->integer('dl_width',false,true)->nullable();
            $table->string('company_phone')->default('+34 123 45 67');
            $table->string('company_email')->default('info@materialista.com');

            //company address
            $table->decimal('lat',9,7)->default(41.3935539);
            $table->decimal('lng',9,7)->default(2.1434673);
            $table->string('formatted_address',510)->default('Av. de Pau Casals, 1, 08021 Barcelona, Barcelona, España');
            $table->integer('street_number',false,true)->default(1);
            $table->string('route')->default('Avinguda de Pau Casals');
            $table->string('locality')->default('Barcelona');
            $table->string('admin_area_lvl2')->default('Barcelona'); //Provincia
            $table->string('admin_area_lvl1')->default('Catalunya'); //Comunidad autónoma
            $table->string('country')->default('España');
            $table->string('postal_code')->default('08021');

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
        Schema::drop('global_cms_constants');
    }
}
