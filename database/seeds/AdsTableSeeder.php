<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');

        $n_house_categories = DB::table('category_house')->count();
        $n_country_house_categories = DB::table('category_country_house')->count();
        $n_business_categories = DB::table('category_business')->count();
        $n_land_categories = DB::table('category_land')->count();
        $n_lodging_categories = DB::table('category_lodging')->count();
        $n_room_categories = DB::table('category_room')->count();

        $n_energy_certification_options = DB::table('energy_certification')->count();
        $n_business_distribution_options = DB::table('business_distribution')->count();
        $n_business_facade_options = DB::table('business_facade')->count();
        $n_business_location_options = DB::table('business_location')->count();
        $n_current_tenants_gender_options = DB::table('current_tenants_gender')->count();
        $n_garage_capacity_options = DB::table('garage_capacity')->count();
        $n_nearest_town_distance_options = DB::table('nearest_town_distance')->count();
        $n_office_distribution_options = DB::table('office_distribution')->count();
        $n_payment_day_options = DB::table('payment_day')->count();
        $n_surroundings_options = DB::table('surroundings')->count();
        $n_tenant_gender_options = DB::table('tenant_gender')->count();
        $n_tenant_min_stay_options = DB::table('tenant_min_stay')->count();
        $n_tenant_occupation_options = DB::table('tenant_occupation')->count();
        $n_tenant_sexual_orientation_options = DB::table('tenant_sexual_orientation')->count();

        $performances = ['75','100','125','150','175','200','225','250'];
        $certs = ['A','B','C','D','E','F','G'];
        $blocks = ['A','B','C','D','E'];
        $doors = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U',
            'V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16',
            '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','Puerta única',
            'Izquierda','Derecha','Exterior','Interior','Centro','Exterior izquierda','Exterior derecha',
            'Interior izquierda','Interior derecha','Centro izquierda','Centro derecha'];
        $floors = ['Planta 1','Planta 2','Planta 3','Planta 4','Planta 5','Planta 6','Planta 7',
            'Planta 8','Planta 9', 'Planta 10','Planta 11','Planta 12','Planta 13','Planta 14',
            'Planta 15','Planta 16', 'Planta 17','Planta 18', 'Planta 19','Planta 20','Planta 21',
            'Planta 22','Planta 23','Planta 24','Planta 25', 'Planta 26','Sótano','Semi-sótano',
            'Bajo','Entreplanta','Por debajo de la planta baja (-2)','Por debajo de la planta baja (-1)'];
        $activities = ['Tienda de ropa','Frutería','Panadería','Taller mecánico','Bar','Restaurante',
            'Carnicería','Gestión de residuos industriales','Copistería','Fábrica de papel','Acerería',
            'Alfarería','Fábrica de cemento','Fábrica de mezcla bituminosa','Tienda de respuestos'];

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(600,2000);
            $deposit = $price*3;
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;

            $newAd = App\Ad::create();
            $newRentHouse = \App\RentHouse::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_house_id'         => mt_rand(1,$n_house_categories),
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'area_land'                 => $area_land,
                'n_floors'                  => mt_rand(1,4),
                'n_bedrooms'                => mt_rand(1,4),
                'n_bathrooms'               => mt_rand(1,4),
                'has_equipped_kitchen'      => mt_rand(0,1),
                'has_furniture'             => mt_rand(0,1),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'faces_north'               => mt_rand(0,1),
                'faces_south'               => mt_rand(0,1),
                'faces_east'                => mt_rand(0,1),
                'faces_west'                => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_terrace'               => mt_rand(0,1),
                'has_box_room'              => mt_rand(0,1),
                'has_parking_space'         => mt_rand(0,1),
                'has_fireplace'             => mt_rand(0,1),
                'has_swimming_pool'         => mt_rand(0,1),
                'has_garden'                => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent House (id: '.$newRentHouse->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(100000,1000000);
            $community_cost = (mt_rand(0,5)) ? null : mt_rand(10,100);
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;

            $newAd = App\Ad::create();
            $newSellHouse = \App\SellHouse::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'community_cost'            => $community_cost,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_house_id'         => mt_rand(1,$n_house_categories),
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'area_land'                 => $area_land,
                'n_floors'                  => mt_rand(1,4),
                'n_bedrooms'                => mt_rand(1,4),
                'n_bathrooms'               => mt_rand(1,4),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'faces_north'               => mt_rand(0,1),
                'faces_south'               => mt_rand(0,1),
                'faces_east'                => mt_rand(0,1),
                'faces_west'                => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_terrace'               => mt_rand(0,1),
                'has_box_room'              => mt_rand(0,1),
                'has_parking_space'         => mt_rand(0,1),
                'has_fireplace'             => mt_rand(0,1),
                'has_swimming_pool'         => mt_rand(0,1),
                'has_garden'                => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell House (id: '.$newSellHouse->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(100000,1000000);
            $community_cost = (mt_rand(0,5)) ? null : mt_rand(10,100);
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(300,2400);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;

            $newAd = App\Ad::create();
            $newSellCountryHouse = \App\SellCountryHouse::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'community_cost'            => $community_cost,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_country_house_id' => mt_rand(1,$n_country_house_categories),
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'area_land'                 => $area_land,
                'n_floors'                  => mt_rand(1,4),
                'n_bedrooms'                => mt_rand(1,4),
                'n_bathrooms'               => mt_rand(1,4),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'faces_north'               => mt_rand(0,1),
                'faces_south'               => mt_rand(0,1),
                'faces_east'                => mt_rand(0,1),
                'faces_west'                => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_terrace'               => mt_rand(0,1),
                'has_box_room'              => mt_rand(0,1),
                'has_parking_space'         => mt_rand(0,1),
                'has_fireplace'             => mt_rand(0,1),
                'has_swimming_pool'         => mt_rand(0,1),
                'has_garden'                => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell Country House (id: '.$newSellCountryHouse->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(600,2000);
            $deposit = $price*3;
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(300,2400);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;

            $newAd = App\Ad::create();
            $newRentCountryHouse = \App\RentCountryHouse::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_country_house_id' => mt_rand(1,$n_country_house_categories),
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'area_land'                 => $area_land,
                'n_floors'                  => mt_rand(1,4),
                'n_bedrooms'                => mt_rand(1,4),
                'n_bathrooms'               => mt_rand(1,4),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'faces_north'               => mt_rand(0,1),
                'faces_south'               => mt_rand(0,1),
                'faces_east'                => mt_rand(0,1),
                'faces_west'                => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_terrace'               => mt_rand(0,1),
                'has_box_room'              => mt_rand(0,1),
                'has_parking_space'         => mt_rand(0,1),
                'has_fireplace'             => mt_rand(0,1),
                'has_swimming_pool'         => mt_rand(0,1),
                'has_garden'                => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Country House (id: '.$newRentCountryHouse->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(600,2000);
            $deposit = $price*3;
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $area_min_for_sale = (int) (mt_rand(5,10)/10) * $area_usable;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;

            $newAd = App\Ad::create();
            $newRentOffice = \App\RentOffice::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'area_min_for_sale'         => $area_min_for_sale,
                'n_floors'                  => mt_rand(1,4),
                'has_offices_only'          => mt_rand(0,1),
                'office_distribution_id'    => mt_rand(1,$n_office_distribution_options),
                'n_restrooms'               => mt_rand(1,8),
                'has_bathrooms'             => mt_rand(0,1),
                'has_fire_detectors'        => mt_rand(0,1),
                'has_fire_extinguishers'    => mt_rand(0,1),
                'has_fire_sprinklers'       => mt_rand(0,1),
                'has_fireproof_doors'       => mt_rand(0,1),
                'has_emergency_lights'      => mt_rand(0,1),
                'has_doorman'               => mt_rand(0,1),
                'has_air_conditioning_pre-installation' => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_heating'               => mt_rand(0,1),
                'has_hot_water'             => mt_rand(0,1),
                'has_kitchen'               => mt_rand(0,1),
                'has_archive'               => mt_rand(0,1),
                'has_double_windows'        => mt_rand(0,1),
                'has_suspended_ceiling'     => mt_rand(0,1),
                'has_suspended_floor'       => mt_rand(0,1),
                'is_handicapped_adapted'    => mt_rand(0,1),
                'has_bathrooms_inside'      => mt_rand(0,1),
                'is_exterior'               => mt_rand(0,1),
                'n_elevators'               => mt_rand(1,8),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'n_parking_spaces'          => mt_rand(10,50),
                'has_steel_door'            => mt_rand(0,1),
                'has_security_system'       => mt_rand(0,1),
                'has_access_control'        => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Office (id: '.$newRentOffice->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(100000,1000000);
            $community_cost = (mt_rand(0,5)) ? null : mt_rand(10,300);
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $area_min_for_sale = (int) (mt_rand(5,10)/10) * $area_usable;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;

            $newAd = App\Ad::create();
            $newSellOffice = \App\SellOffice::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'community_cost'            => $community_cost,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'area_min_for_sale'         => $area_min_for_sale,
                'n_floors'                  => mt_rand(1,4),
                'has_offices_only'          => mt_rand(0,1),
                'office_distribution_id'    => mt_rand(1,$n_office_distribution_options),
                'n_restrooms'               => mt_rand(1,8),
                'has_bathrooms'             => mt_rand(0,1),
                'has_fire_detectors'        => mt_rand(0,1),
                'has_fire_extinguishers'    => mt_rand(0,1),
                'has_fire_sprinklers'       => mt_rand(0,1),
                'has_fireproof_doors'       => mt_rand(0,1),
                'has_emergency_lights'      => mt_rand(0,1),
                'has_doorman'               => mt_rand(0,1),
                'has_air_conditioning_pre-installation' => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_heating'               => mt_rand(0,1),
                'has_hot_water'             => mt_rand(0,1),
                'has_kitchen'               => mt_rand(0,1),
                'has_archive'               => mt_rand(0,1),
                'has_double_windows'        => mt_rand(0,1),
                'has_suspended_ceiling'     => mt_rand(0,1),
                'has_suspended_floor'       => mt_rand(0,1),
                'is_handicapped_adapted'    => mt_rand(0,1),
                'has_bathrooms_inside'      => mt_rand(0,1),
                'is_exterior'               => mt_rand(0,1),
                'n_elevators'               => mt_rand(1,8),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'n_parking_spaces'          => mt_rand(10,50),
                'has_steel_door'            => mt_rand(0,1),
                'has_security_system'       => mt_rand(0,1),
                'has_access_control'        => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell Office (id: '.$newSellOffice->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(600,2000);
            $deposit = $price*3;
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;

            $newAd = App\Ad::create();
            $newRentBusiness = \App\RentBusiness::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'is_transfer'               => mt_rand(0,1),
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'category_business_id'      => mt_rand(1,$n_business_categories),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'business_distribution_id'  => mt_rand(1,$n_business_distribution_options),
                'business_facade_id'        => mt_rand(1,$n_business_facade_options),
                'n_shop_windows'            => mt_rand(1,4),
                'business_location_id'      => mt_rand(1,$n_business_location_options),
                'n_floors'                  => mt_rand(1,3),
                'n_restrooms'               => mt_rand(1,4),
                'last_activity'             => $activities[array_rand($activities)],
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'has_archive'               => mt_rand(0,1),
                'has_smoke_extractor'       => mt_rand(0,1),
                'has_fully_equipped_kitchen' => mt_rand(0,1),
                'has_steel_door'            => mt_rand(0,1),
                'has_alarm'                 => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_heating'               => mt_rand(0,1),
                'has_security_camera'       => mt_rand(0,1),
                'is_corner_located'         => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Business (id: '.$newRentBusiness->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(100000,1000000);
            $community_cost = (mt_rand(0,5)) ? null : mt_rand(10,300);
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;

            $newAd = App\Ad::create();
            $newSellBusiness = \App\SellBusiness::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'community_cost'            => $community_cost,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'category_business_id'      => mt_rand(1,$n_business_categories),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'business_distribution_id'  => mt_rand(1,$n_business_distribution_options),
                'business_facade_id'        => mt_rand(1,$n_business_facade_options),
                'n_shop_windows'            => mt_rand(1,4),
                'business_location_id'      => mt_rand(1,$n_business_location_options),
                'n_floors'                  => mt_rand(1,3),
                'n_restrooms'               => mt_rand(1,4),
                'last_activity'             => $activities[array_rand($activities)],
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'has_archive'               => mt_rand(0,1),
                'has_smoke_extractor'       => mt_rand(0,1),
                'has_fully_equipped_kitchen' => mt_rand(0,1),
                'has_steel_door'            => mt_rand(0,1),
                'has_alarm'                 => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_heating'               => mt_rand(0,1),
                'has_security_camera'       => mt_rand(0,1),
                'is_corner_located'         => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell Business (id: '.$newSellBusiness->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(10000,100000);
            $community_cost = (mt_rand(0,5)) ? null : mt_rand(10,100);

            $newAd = App\Ad::create();
            $newSellGarage = \App\SellGarage::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'community_cost'            => $community_cost,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'garage_capacity_id'        => mt_rand(1,$n_garage_capacity_options),
                'is_covered'                => mt_rand(0,1),
                'has_automatic_door'        => mt_rand(0,1),
                'has_lift'                  => mt_rand(0,1),
                'has_alarm'                 => mt_rand(0,1),
                'has_security_camera'       => mt_rand(0,1),
                'has_security_guard'        => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell Garage (id: '.$newSellGarage->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(100,1000);
            $deposit = $price*3;

            $newAd = App\Ad::create();
            $newRentGarage = \App\RentGarage::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'garage_capacity_id'        => mt_rand(1,$n_garage_capacity_options),
                'is_covered'                => mt_rand(0,1),
                'has_automatic_door'        => mt_rand(0,1),
                'has_lift'                  => mt_rand(0,1),
                'has_alarm'                 => mt_rand(0,1),
                'has_security_camera'       => mt_rand(0,1),
                'has_security_guard'        => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Garage (id: '.$newRentGarage->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(50000,500000);
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $area_min_for_sale = (int) (mt_rand(5,10)/10) * $area_usable;

            $newAd = App\Ad::create();
            $newSellLand = \App\SellLand::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_land_id'          => mt_rand(1,$n_land_categories),
                'area_total'                => $area_land,
                'area_building_land'        => $area_constructed,
                'area_min_for_sale'         => $area_min_for_sale,
                'is_classified_residential_block' => mt_rand(0,1),
                'is_classified_residential_house' => mt_rand(0,1),
                'is_classified_office'      => mt_rand(0,1),
                'is_classified_commercial'  => mt_rand(0,1),
                'is_classified_hotel'       => mt_rand(0,1),
                'is_classified_industrial'  => mt_rand(0,1),
                'is_classified_public_service' => mt_rand(0,1),
                'is_classified_others'      => mt_rand(0,1),
                'max_floors_allowed'        => (mt_rand(0,5)) ? mt_rand(1,3) : mt_rand(1,30),
                'has_road_access'           => mt_rand(0,1),
                'nearest_town_distance_id'  => mt_rand(1,$n_nearest_town_distance_options),
                'has_water'                 => mt_rand(0,1),
                'has_electricity'           => mt_rand(0,1),
                'has_sewer_system'          => mt_rand(0,1),
                'has_natural_gas'           => mt_rand(0,1),
                'has_street_lighting'       => mt_rand(0,1),
                'has_sidewalks'             => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell Land (id: '.$newSellLand->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(200,5000);
            $deposit = $price*3;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $area_min_for_sale = (int) (mt_rand(5,10)/10) * $area_usable;

            $newAd = App\Ad::create();
            $newRentLand = \App\RentLand::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_land_id'          => mt_rand(1,$n_land_categories),
                'area_total'                => $area_land,
                'area_building_land'        => $area_constructed,
                'area_min_for_sale'         => $area_min_for_sale,
                'is_classified_residential_block' => mt_rand(0,1),
                'is_classified_residential_house' => mt_rand(0,1),
                'is_classified_office'      => mt_rand(0,1),
                'is_classified_commercial'  => mt_rand(0,1),
                'is_classified_hotel'       => mt_rand(0,1),
                'is_classified_industrial'  => mt_rand(0,1),
                'is_classified_public_service' => mt_rand(0,1),
                'is_classified_others'      => mt_rand(0,1),
                'max_floors_allowed'        => (mt_rand(0,5)) ? mt_rand(1,3) : mt_rand(1,30),
                'has_road_access'           => mt_rand(0,1),
                'nearest_town_distance_id'  => mt_rand(1,$n_nearest_town_distance_options),
                'has_water'                 => mt_rand(0,1),
                'has_electricity'           => mt_rand(0,1),
                'has_sewer_system'          => mt_rand(0,1),
                'has_natural_gas'           => mt_rand(0,1),
                'has_street_lighting'       => mt_rand(0,1),
                'has_sidewalks'             => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Land (id: '.$newRentLand->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(600,2000);
            $deposit = $price*3;
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;

            $newAd = App\Ad::create();
            $newRentApartment = \App\RentApartment::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'is_last_floor'             => mt_rand(0,1),
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'is_regular'                => mt_rand(0,1),
                'is_penthouse'              => mt_rand(0,1),
                'is_duplex'                 => mt_rand(0,1),
                'is_studio'                 => mt_rand(0,1),
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'n_bedrooms'                => mt_rand(1,5),
                'n_bathrooms'               => mt_rand(1,3),
                'is_exterior'               => mt_rand(0,1),
                'has_equipped_kitchen'      => mt_rand(0,1),
                'has_furniture'             => mt_rand(0,1),
                'has_elevator'              => mt_rand(0,1),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'faces_north'               => mt_rand(0,1),
                'faces_south'               => mt_rand(0,1),
                'faces_east'                => mt_rand(0,1),
                'faces_west'                => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_terrace'               => mt_rand(0,1),
                'has_box_room'              => mt_rand(0,1),
                'has_parking_space'         => mt_rand(0,1),
                'has_swimming_pool'         => mt_rand(0,1),
                'has_garden'                => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Apartment (id: '.$newRentApartment->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(100000,1000000);
            $community_cost = (mt_rand(0,5)) ? null : mt_rand(10,300);
            $energy_cert_id = mt_rand(1,$n_energy_certification_options);
            $energy_cert_name = \App\EnergyCertification::find($energy_cert_id)->name;
            $energy_performance = (in_array($energy_cert_name,$certs)) ? $performances[array_rand($performances)] : null;
            $area_land = mt_rand(100,800);
            $area_constructed = (int) 0.6 * $area_land;
            $area_usable = (int) 0.8 * $area_constructed;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;

            $newAd = App\Ad::create();
            $newSellApartment = \App\SellApartment::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'community_cost'            => $community_cost,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'is_last_floor'             => mt_rand(0,1),
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'is_regular'                => mt_rand(0,1),
                'is_penthouse'              => mt_rand(0,1),
                'is_duplex'                 => mt_rand(0,1),
                'is_studio'                 => mt_rand(0,1),
                'needs_restoration'         => mt_rand(0,1),
                'area_constructed'          => $area_constructed,
                'area_usable'               => $area_usable,
                'n_bedrooms'                => mt_rand(1,5),
                'n_bathrooms'               => mt_rand(1,3),
                'is_exterior'               => mt_rand(0,1),
                'has_elevator'              => mt_rand(0,1),
                'energy_certification_id'   => $energy_cert_id,
                'energy_performance'        => $energy_performance,
                'faces_north'               => mt_rand(0,1),
                'faces_south'               => mt_rand(0,1),
                'faces_east'                => mt_rand(0,1),
                'faces_west'                => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_terrace'               => mt_rand(0,1),
                'has_box_room'              => mt_rand(0,1),
                'has_parking_space'         => mt_rand(0,1),
                'has_swimming_pool'         => mt_rand(0,1),
                'has_garden'                => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Sell Apartment (id: '.$newSellApartment->id.')');
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;
            $n_d_b = mt_rand(0,2);
            $n_1_b = mt_rand(0,2);
            $n_2_b = mt_rand(0,2);
            $n_3_b = mt_rand(0,1);
            $n_4_b = mt_rand(0,1);
            $min_capacity = $n_d_b * 2 + $n_1_b + $n_2_b * 2 + $n_3_b * 3 + $n_4_b * 4;
            $n_sb = mt_rand(0,1);
            $n_d_sb = mt_rand(0,1);
            $n_eb = mt_rand(0,1);
            $max_capacity = $min_capacity + $n_sb + $n_d_sb * 2 + $n_eb;
            $payment_day = mt_rand(1,$n_payment_day_options);
            $days_before = (\App\OptionPaymentDay::find($payment_day)->name == 'Días antes') ? mt_rand(1,30) : null;

            $newAd = App\Ad::create();
            $newRentVacation = \App\Lodging::create([
                'ad_id'                     => $newAd->id,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'is_last_floor'             => mt_rand(0,1),
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'surroundings_id'           => mt_rand(1,$n_surroundings_options),
                'category_lodging_id'       => mt_rand(1,$n_lodging_categories),
                'has_multiple_lodgings'     => mt_rand(0,1),
                'distance_to_beach'         => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_town_center'   => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_ski_area'      => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_golf_course'   => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_airport'       => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_supermarket'   => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_river_or_lake' => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_marina'         => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_horse_riding_area' => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_scuba_diving_area' => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_train_station' => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_bus_station'   => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_hospital'      => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'distance_to_hiking_area'   => (mt_rand(0,5)) ? null : mt_rand(250,10000),
                'n_double_bedroom'          => $n_d_b,
                'n_two_beds_room'           => $n_2_b,
                'n_single_bed_room'         => $n_1_b,
                'n_three_beds_room'         => $n_3_b,
                'n_four_beds_room'          => $n_4_b,
                'n_sofa-bed'                => $n_sb,
                'n_double_sofa-bed'         => $n_d_sb,
                'n_extra_bed'               => $n_eb,
                'min_capacity'              => $min_capacity,
                'max_capacity'              => $max_capacity,
                'payment_day_id'            => $payment_day,
                'n_days_before'             => $days_before,
                'booking'                   => (mt_rand(0,5)) ? null : mt_rand(250,550),
                'deposit'                   => (mt_rand(0,5)) ? null : mt_rand(350,1550),
                'cleaning'                  => (mt_rand(0,5)) ? null : mt_rand(50,350),
                'has_included_towels' => mt_rand(0,1),
                'has_included_expenses' => mt_rand(0,1),
                'accepts_cash' => mt_rand(0,1),
                'accepts_transfer' => mt_rand(0,1),
                'accepts_credit_card' => mt_rand(0,1),
                'accepts_paypal' => mt_rand(0,1),
                'accepts_check' => mt_rand(0,1),
                'accepts_western_union' => mt_rand(0,1),
                'accepts_money_gram' => mt_rand(0,1),
                'has_barbecue' => mt_rand(0,1),
                'has_terrace' => mt_rand(0,1),
                'has_private_swimming_pool' => mt_rand(0,1),
                'has_shared_swimming_pool' => mt_rand(0,1),
                'has_indoor_swimming_pool' => mt_rand(0,1),
                'has_private_garden' => mt_rand(0,1) ,
                'has_shared_garden' => mt_rand(0,1),
                'has_furnished_garden' => mt_rand(0,1),
                'has_parking_space' => mt_rand(0,1),
                'has_playground' => mt_rand(0,1),
                'has_mountain_sights' => mt_rand(0,1),
                'has_sea_sights' => mt_rand(0,1),
                'has_fireplace' => mt_rand(0,1),
                'has_air_conditioning' => mt_rand(0,1),
                'has_jacuzzi' => mt_rand(0,1),
                'has_tv' => mt_rand(0,1),
                'has_cable_tv' => mt_rand(0,1),
                'has_internet' => mt_rand(0,1),
                'has_heating' => mt_rand(0,1),
                'has_fan' => mt_rand(0,1),
                'has_cradle' => mt_rand(0,1),
                'has_hairdryer' => mt_rand(0,1),
                'has_dishwasher' => mt_rand(0,1),
                'has_fridge' => mt_rand(0,1),
                'has_oven' => mt_rand(0,1),
                'has_microwave' => mt_rand(0,1),
                'has_coffee_maker' => mt_rand(0,1),
                'has_dryer' => mt_rand(0,1),
                'has_washer' => mt_rand(0,1),
                'has_iron' => mt_rand(0,1),
                'is_smoking_allowed' => mt_rand(0,1),
                'is_pet_allowed' => mt_rand(0,1),
                'has_elevator' => mt_rand(0,1),
                'is_car_recommended' => mt_rand(0,1),
                'is_handicapped_adapted' => mt_rand(0,1),
                'is_out_town_center' => mt_rand(0,1),
                'is_isolated' => mt_rand(0,1),
                'is_nudist_area' => mt_rand(0,1),
                'is_bar_area' => mt_rand(0,1),
                'is_gayfriendly_area' => mt_rand(0,1),
                'is_family_tourism_area' => mt_rand(0,1),
                'is_luxury_area' => mt_rand(0,1),
                'is_charming' => mt_rand(0,1),
                'has_bicycle_rental' => mt_rand(0,1),
                'has_car_rental' => mt_rand(0,1),
                'has_adventure_activities' => mt_rand(0,1),
                'has_kindergarten' => mt_rand(0,1),
                'has_sauna' => mt_rand(0,1),
                'has_tennis_court' => mt_rand(0,1),
                'has_paddle_court' => mt_rand(0,1),
                'has_gym' => mt_rand(0,1),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Vacation (id: '.$newRentVacation->id.')');

            $n_seasons_prices = mt_rand(1,4);
            for($j=0; $j<$n_seasons_prices; $j++) {
                $from_date = \Carbon\Carbon::createFromDate(null, mt_rand(1,12), 1);
                $to_date = $from_date->addMonths(mt_rand(1,3));
                $newSeasonPrice = \App\SeasonPrice::create([
                    'n_season' => $j+1,
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'p_one_night' => mt_rand(15,50),
                    'p_weekend_night' => 10 + mt_rand(15,50),
                    'p_one_week' => mt_rand(10,40),
                    'p_half_month' => mt_rand(8, 35),
                    'p_one_month' => mt_rand(5,30),
                    'p_extra_guest_per_night' => mt_rand(5,30),
                    'n_min_nights' => mt_rand(1,30),
                    'rent_vacation_id' => $newRentVacation->id,
                ]);
                $this->command->info('Seeded Season Price (id: '.$newSeasonPrice->id.') for Rent Vacation (id: '.$newRentVacation->id.')');
            }
        }

        for ($i=0; $i<50; $i++) {
            $location = \App\Geocode::generateRandomLocation();
            $price = mt_rand(250,700);
            $deposit = $price*3;
            $has_block = mt_rand(0,1);
            $block_name = ($has_block) ? $blocks[array_rand($blocks)] : null;
            $n_bedrooms = mt_rand(2,5);
            $n_people = (int) $n_bedrooms/2 + 1;

            $newAd = App\Ad::create();
            $newRentRoom = \App\Room::create([
                'ad_id'                     => $newAd->id,
                'price'                     => $price,
                'deposit'                   => $deposit,
                'lat'                       => isset($location['lat']) ? $location['lat'] : '',
                'lng'                       => isset($location['lng']) ? $location['lng'] : '',
                'formatted_address'         => isset($location['formatted_address']) ? $location['formatted_address'] : '',
                'street_number'             => isset($location['street_number']) ? $location['street_number'] : '',
                'route'                     => isset($location['route']) ? $location['route'] : '',
                'locality'                  => isset($location['locality']) ? $location['locality'] : '',
                'admin_area_lvl2'           => isset($location['administrative_area_level_2']) ? $location['administrative_area_level_2'] : '',
                'admin_area_lvl1'           => isset($location['administrative_area_level_1']) ? $location['administrative_area_level_1'] : '',
                'country'                   => isset($location['country']) ? $location['country'] : '',
                'postal_code'               => isset($location['postal_code']) ? $location['postal_code'] : '',
                'hide_address'              => mt_rand(0,1),
                'floor_number'              => $floors[array_rand($floors)],
                'is_last_floor'             => mt_rand(0,1),
                'door'                      => $doors[array_rand($doors)],
                'has_block'                 => $has_block,
                'block'                     => $block_name,
                'residential_area'          => (mt_rand(0,5)) ? null : $faker->name,
                'category_room_id'          => mt_rand(1,$n_room_categories),
                'area_room'                 => mt_rand(10,50),
                'n_people'                  => $n_people,
                'n_bedrooms'                => $n_bedrooms,
                'n_bathrooms'               => mt_rand(1,2),
                'current_tenants_gender_id' => mt_rand(1,$n_current_tenants_gender_options),
                'is_smoking_allowed'        => mt_rand(0,1),
                'is_pet_allowed'            => mt_rand(0,1),
                'min_current_tenants_age'   => mt_rand(18,23),
                'max_current_tenants_age'   => mt_rand(23,35),
                'has_elevator'              => mt_rand(0,1),
                'has_furniture'             => mt_rand(0,1),
                'has_builtin_closets'       => mt_rand(0,1),
                'has_air_conditioning'      => mt_rand(0,1),
                'has_internet'              => mt_rand(0,1),
                'has_house_keeper'          => mt_rand(0,1),
                'tenant_gender_id'          => mt_rand(1,$n_tenant_gender_options),
                'tenant_occupation_id'      => mt_rand(1,$n_tenant_occupation_options),
                'tenant_sexual_orientation_id' => mt_rand(1,$n_tenant_sexual_orientation_options),
                'tenant_min_stay_id'        => mt_rand(1,$n_tenant_min_stay_options),
                'description'               => $faker->text(1020)
            ]);
            $this->command->info('Seeded Rent Room (id: '.$newRentRoom->id.')');
        }

    }
}
