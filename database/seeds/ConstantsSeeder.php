<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ConstantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //commented or non-set values will default to those set in database/migrations
        App\Constants::create([
            'n_ad_seeds'          => 0, //100
//            'starting_year'       => , //2015
//            'dev_version'         => '', //'1.0'
//            'dev_email'           => '', //'dev@materialista.com'
//            'search_distance'     => , //25
            'company_name'        => 'Valkiria', //'Materialista'
            'company_description' => 'Inmobiliaria y fincas rústicas', //'Oferta inmobiliaria'
            'public_logo'         => '1444230893024612_logo-valkiria.png', //null
            'dashboard_logo'      => '1444230893161418_logo-valkiria-2.png', //null
            'company_email'       => 'contact@valkiria.com',
//            'company_phone'       => '', //'+34 123 45 67'
//            'lat'                 => , //41.3935539
//            'lng'                 => , //2.1434673
//            'formatted_address'   => '', //'Av. de Pau Casals, 1, 08021 Barcelona, Barcelona, España'
//            'street_number'       => , //1
//            'route'               => '', //'Avinguda de Pau Casals'
//            'locality'            => '', //'Barcelona'
//            'admin_area_lvl2'     => '', //'Barcelona'
//            'admin_area_lvl1'     => '', //'Catalunya'
//            'country'             => '', //'España'
//            'postal_code'         => '', //'08021'
        ]);
    }
}
