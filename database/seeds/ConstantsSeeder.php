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
        //commented/not set values will default to those set in the table migration file
        App\Constants::create([
//            'n_ad_seeds'          => 10,
//            'starting_year'       => 2015,
//            'dev_version'         => '0.2',
//            'dev_email'           => 'dev@materialista.com',
            'company_name'        => 'Valkiria',
            'company_description' => 'Inmobiliaria y fincas rústicas',
            'public_logo'         => 'logo-valkiria.png',
            'pl_height'           => 346,
            'pl_width'            => 744,
            'dashboard_logo'      => 'logo-valkiria-2.png',
            'dl_height'           => 77,
            'dl_width'            => 419,
            'company_phone'       => '+34 123 45 67',
            'company_email'       => 'contact@valkiria.com',
//            'lat'                 => 41.3935539,
//            'lng'                 => 2.1434673,
//            'formatted_address'   => 'Av. de Pau Casals, 1, 08021 Barcelona, Barcelona, España',
//            'street_number'       => 1,
//            'route'               => 'Avinguda de Pau Casals',
//            'locality'            => 'Barcelona',
//            'admin_area_lvl2'     => 'Barcelona,
//            'admin_area_lvl1'     => 'Catalunya',
//            'country'             => 'España',
//            'postal_code'         => '08021',
        ]);
    }
}