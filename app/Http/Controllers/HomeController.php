<?php namespace App\Http\Controllers;

use App\Ad;
use App\CategoryBusiness;
use App\CategoryCountryHouse;
use App\CategoryHouse;
use App\CategoryLand;
use App\CategoryLodging;
use App\CategoryRoom;
use App\Geocode;
use App\HomeLib;
use App\Lodging;
use App\OptionBusinessDistribution;
use App\OptionBusinessFacade;
use App\OptionBusinessLocation;
use App\OptionCurrentTenantsGender;
use App\OptionGarageCapacity;
use App\OptionNearestTownDistance;
use App\OptionOfficeDistribution;
use App\OptionPaymentDay;
use App\OptionSurroundings;
use App\OptionTenantGender;
use App\OptionTenantMinStay;
use App\OptionTenantOccupation;
use App\OptionTenantSexualOrientation;
use App\RentApartment;
use App\RentBusiness;
use App\RentCountryHouse;
use App\RentGarage;
use App\RentHouse;
use App\RentLand;
use App\RentOffice;
use App\Room;
use App\SeasonPrice;
use App\SellApartment;
use App\SellBusiness;
use App\SellCountryHouse;
use App\SellGarage;
use App\SellHouse;
use App\SellLand;
use App\SellOffice;

class HomeController extends Controller {

    public function __construct()
    {
        //
    }

    public function index()
    {
        return view('home_search');
    }

    public function postAdminsAndLocalities()
    {
        $input = \Input::all();
        $response = [];
        $response['admins'] = HomeLib::getAdminLvl2List($input['operation'],$input['typology']);
        $adminLvl = (isset($response['admins'][0]->admin_area_lvl2)) ? $response['admins'][0]->admin_area_lvl2 : '';
        $response['localities'] = HomeLib::getLocalityList($input['operation'],$input['typology'],$adminLvl);

        return \Response::json($response,200);
    }

    public function postLocalities()
    {
        $input = \Input::all();
        $response = [];
        $response['localities'] = HomeLib::getLocalityList($input['operation'],$input['typology'],$input['adminLvl2']);

        return \Response::json($response,200);
    }

    public function getResults()
    {
        /*
         * Possible search types from HOME/SEARCH:
         * 0 by locality (locality provided)
         * 1 by proximity (lat, lng calculated from provided address)
         *
         * possible operations from HOME/SEARCH:
         * 0 Buy
         * 1 Rent
         * 2 Share
         *
         * possible typologies from HOME/SEARCH:
         * 0 New development
         * 1 Houses + country houses + apartments
         * 2 Vacation
         * 3 Room
         * 4 Office
         * 5 Business
         * 6 Garage
         * 7 Land
         */

        $input = \Input::all();

        // Input validation
        if($input['operation']=='0')
            $allowed_price_values = '1000000,2000000,3000000,950000,900000,850000,750000,700000,650000,600000,550000,'.
                '500000,450000,400000,380000,360000,340000,320000,300000,280000,260000,240000,220000,200000,180000,'.
                '160000,140000,120000,100000,80000,60000';
        else
            $allowed_price_values = '3000,2700,2400,2100,2000,1900,1800,1700,1600,1500,1400,1300,1200,1100,1000,900,'.
                '800,700,600,500,400,300,200,100';
        $rules = array(
            'operation'     => 'required|digits:1|in:0,1,2',
            'typology'      => 'required|digits:1',
            'search_type'   => 'required|digits:1|in:0,1',
            'locality'      => 'sometimes|string|max:255',
            'address'       => 'sometimes|string|max:510',
            'price-min'     => 'sometimes|string|in:'.$allowed_price_values,
            'price-max'     => 'sometimes|string|in:'.$allowed_price_values
        );
        $validator =  \Validator::make($input,$rules);
        if($validator->fails())
            return \Redirect::route('home');

        // Set default values
        if(!isset($input['operation']))
            $input['operation'] = '0';
        if(!isset($input['typology']))
            $input['typology'] = '1';
        if(!isset($input['locality']))
            $input['locality'] = 'Barcelona';
        if(!isset($input['search_type']))
            $input['search_type'] = '0';
        if(!isset($input['address'])||$input['address']=='')
            $input['address'] = $input['locality'];
        if(!isset($input['price-min'])||$input['price-min']=='')
            $input['price-min'] = 0;
        if(!isset($input['price-max'])||$input['price-max']=='')
            $input['price-max'] = 0;

        // Set minimum and maximum prices when no price range provided
        $price_min = ($input['price-min']) ? (int) $input['price-min'] : -1;
        $price_max = ($input['price-max']) ? (int) $input['price-max'] : 999999999;

        // Share a house = Rent a room
        if($input['operation']=='2'&&$input['typology']=='1') {
            $input['operation']='1';
            $input['typology']='3';
        }

        // Search queries
        if($input['search_type']=='0') {
            $locality = $input['locality'];
            switch ($input['operation']) {
                case '0': //buy
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,has_elevator,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,'0' as has_elevator,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1 AND t1.locality = ? AND t1.price >= ? AND t1.price <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ? AND t2.price >= ? AND t2.price <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_elevator,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ? AND t3.price >= ? AND t3.price <= ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,has_elevator,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,'0' as has_elevator,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.locality = ? AND t2.price >= ? AND t2.price <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.has_elevator,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM sell_apartment AS t3
                                      WHERE t3.locality = ? AND t3.price >= ? AND t3.price <= ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Oficina' as type,area_constructed as area,hide_address,ad_id
                              FROM sell_office AS t1
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Garaje' as type,area_constructed as area,hide_address,ad_id
                              FROM sell_business AS t1
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,'Garaje' as type,`name` as garage_capacity,hide_address,ad_id
                              FROM sell_garage AS t1
                              LEFT JOIN garage_capacity AS t2 ON t1.garage_capacity_id = t2.id
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,area_total as area,'Terreno' as type,`name` as land_category,hide_address,ad_id
                              FROM sell_land AS t1
                              LEFT JOIN category_land AS t2 ON t1.category_land_id = t2.id
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,has_elevator,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,'0' as has_elevator,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1 AND t1.locality = ? AND t1.price >= ? AND t1.price <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ? AND t2.price >= ? AND t2.price <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.has_elevator,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM rent_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ? AND t3.price >= ? AND t3.price <= ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,has_elevator,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,'0' as has_elevator,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.locality = ? AND t2.price >= ? AND t2.price <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.has_elevator,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM rent_apartment AS t3
                                      WHERE t3.locality = ? AND t3.price >= ? AND t3.price <= ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '2': //vacation/lodge
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,description,t2.`name` as type,t4.`name` as surroundings,area_total as area,min_capacity,max_capacity,hide_address,MIN(p_one_month) as min_price_per_night,ad_id
                              FROM rent_vacation AS t1
                              LEFT JOIN category_lodging AS t2 ON t1.category_lodging_id = t2.id
                              LEFT JOIN vacation_season_price AS t3 ON t1.id = t3.rent_vacation_id
                              LEFT JOIN surroundings AS t4 ON t1.surroundings_id = t4.id
                              WHERE t1.locality = ?
                              HAVING min_price_per_night >= ? AND min_price_per_night <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '3': //room
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Habitación' as type,area_room as area,hide_address,ad_id
                              FROM rent_room AS t1
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Oficina' as type,area_constructed as area,hide_address,ad_id
                              FROM rent_office AS t1
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,`name` as type,area_constructed as area,hide_address,ad_id
                              FROM rent_business AS t1
                              LEFT JOIN category_business AS t2 ON t1.category_business_id = t2.id
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,'Garaje' as type,`name` as garage_capacity,hide_address,ad_id
                              FROM rent_garage AS t1
                              LEFT JOIN garage_capacity AS t2 ON t1.garage_capacity_id = t2.id
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,area_total as area,'Terreno' as type,`name` as land_category,hide_address,ad_id
                              FROM rent_land AS t1
                              LEFT JOIN category_land AS t2 ON t1.category_land_id = t2.id
                              WHERE t1.locality = ? AND t1.price >= ? AND t1.price <= ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                    }
                    break;
            }
        } else { // Geo-located search queries
            // Geo-locate address
            $location = Geocode::geocodeAddress($input['address']);
            if(!$location)
                return \Redirect::back();
            $locality = $location['locality'];

            // Geo-distance calculations
            $R = 6371.01; //radio de la tierra promedio (en km)
            $distance = \App\Constants::first()->search_distance;
            $r = $distance/$R; //ángulo en radianes que equivale a recorrer $distance sobre un círculo de radio $R
            $lat_r = deg2rad($location['lat']); //en rads
            $lng_r = deg2rad($location['lng']); //en rads
            $min_lat = rad2deg($lat_r-$r); //en sexag
            $max_lat = rad2deg($lat_r+$r); //en sexag
            $delta_lng = asin(sin($r)/cos($lat_r)); //en rads
            $min_lng = rad2deg($lng_r-$delta_lng); //en sexag
            $max_lng = rad2deg($lng_r+$delta_lng); //en sexag

            // DB queries
            switch ($input['operation']) {
                case '0': //buy
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1
                                      AND t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t2.lat))+COS({$lat_r})*COS(RADIANS(t2.lat))*COS(RADIANS(t2.lng)-{$lng_r}))) AS distance
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1
                                      AND t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND t2.price >= ? AND t2.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t3.lat))+COS({$lat_r})*COS(RADIANS(t3.lat))*COS(RADIANS(t3.lng)-{$lng_r}))) AS distance
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1
                                      AND t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND t3.price >= ? AND t3.price <= ?
                                      HAVING distance <= ?
                                ) AS t4
                                ORDER BY t4.distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t2.lat))+COS({$lat_r})*COS(RADIANS(t2.lat))*COS(RADIANS(t2.lng)-{$lng_r}))) AS distance
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND t2.price >= ? AND t2.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t3.lat))+COS({$lat_r})*COS(RADIANS(t3.lat))*COS(RADIANS(t3.lng)-{$lng_r}))) AS distance
                                      FROM sell_apartment AS t3
                                      WHERE t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND t3.price >= ? AND t3.price <= ?
                                      HAVING distance <= ?
                                ) AS t4
                                ORDER BY t4.distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Oficina' as type,area_constructed as area,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM sell_office AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,`name` as type,area_constructed as area,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM sell_business AS t1
                              LEFT JOIN category_business AS t2 ON t1.category_business_id = t2.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,'Garaje' as type,`name` as garage_capacity,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM sell_garage AS t1
                              LEFT JOIN garage_capacity AS t2 ON t1.garage_capacity_id = t2.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,area_total as area,'Terreno' as type,`name` as land_category,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM sell_land AS t1
                              LEFT JOIN category_land AS t2 ON t1.category_land_id = t2.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1
                                      AND t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t2.lat))+COS({$lat_r})*COS(RADIANS(t2.lat))*COS(RADIANS(t2.lng)-{$lng_r}))) AS distance
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1
                                      AND t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND t2.price >= ? AND t2.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t3.lat))+COS({$lat_r})*COS(RADIANS(t3.lat))*COS(RADIANS(t3.lng)-{$lng_r}))) AS distance
                                      FROM rent_apartment AS t3
                                      WHERE t3.is_new_development = 1
                                      AND t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND t3.price >= ? AND t3.price <= ?
                                      HAVING distance <= ?
                                ) AS t4
                                ORDER BY t4.distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t2.lat))+COS({$lat_r})*COS(RADIANS(t2.lat))*COS(RADIANS(t2.lng)-{$lng_r}))) AS distance
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND t2.price >= ? AND t2.price <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,
                                      ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t3.lat))+COS({$lat_r})*COS(RADIANS(t3.lat))*COS(RADIANS(t3.lng)-{$lng_r}))) AS distance
                                      FROM rent_apartment AS t3
                                      WHERE t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND t3.price >= ? AND t3.price <= ?
                                      HAVING distance <= ?
                                ) AS t4
                                ORDER BY t4.distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '2': //vacation/lodge
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,description,t2.`name` as type,t4.`name` as surroundings,area_total as area,min_capacity,max_capacity,hide_address,MIN(p_one_month) as min_price_per_night,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM rent_vacation AS t1
                              LEFT JOIN category_lodging AS t2 ON t1.category_lodging_id = t2.id
                              LEFT JOIN vacation_season_price AS t3 ON t1.id = t3.rent_vacation_id
                              LEFT JOIN surroundings AS t4 ON t1.surroundings_id = t4.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ? AND min_price_per_night >= ? AND min_price_per_night <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$distance,$price_min,$price_max]);
                            break;
                        case '3': //room
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Habitación' as type,area_room as area,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM rent_room AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Oficina' as type,area_constructed as area,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM rent_office AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,`name` as type,area_constructed as area,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM rent_business AS t1
                              LEFT JOIN category_business AS t2 ON t1.category_business_id = t2.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,'Garaje' as type,`name` as garage_capacity,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM rent_garage AS t1
                              LEFT JOIN garage_capacity AS t2 ON t1.garage_capacity_id = t2.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,area_total as area,'Terreno' as type,`name` as land_category,hide_address,ad_id,
                              ({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(t1.lat))+COS({$lat_r})*COS(RADIANS(t1.lat))*COS(RADIANS(t1.lng)-{$lng_r}))) AS distance
                              FROM rent_land AS t1
                              LEFT JOIN category_land AS t2 ON t1.category_land_id = t2.id
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND t1.price >= ? AND t1.price <= ?
                              HAVING distance <= ?
                              ORDER BY distance ASC;
                            "),[$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                    }
                    break;
            }
        }

        // Prepare a human readable typology string for the results view
        switch ($input['typology']) {
            case '0': //new development
                $typology = 'promociones de obra nueva';
                break;
            case '1': //house + country house + apartment
                $typology = 'casas y pisos';
                break;
            case '2': //vacation/lodge
                $typology = 'alquileres vacacionales';
                break;
            case '3': //room
                $typology = 'habitaciones';
                break;
            case '4': //office
                $typology = 'oficinas';
                break;
            case '5': //business
                $typology = 'locales o naves';
                break;
            case '6': //garage
                $typology = 'garajes';
                break;
            case '7': //land
                $typology = 'terrenos';
                break;
            default:
                $typology = 'inmueble';
                break;
        }

        // Search type as a variable, to be sent to the results view
        $search_type = $input['search_type'];

        return view('results',compact('ads','typology','locality','search_type','input'));
    }

    public function adProfile($id)
    {
        $Ad = Ad::findOrFail($id);

        //specific operation and typology codes for the profile page
        $txt = explode('_',$Ad->local_table,2);
        switch($txt[0]) {
            case 'sell':
                switch($txt[1]) {
                    case 'house':
                        $ad = SellHouse::findOrFail($Ad->local_id);
                        break;
                    case 'apartment':
                        $ad = SellApartment::findOrFail($Ad->local_id);
                        break;
                    case 'country_house':
                        $ad = SellCountryHouse::findOrFail($Ad->local_id);
                        break;
                    case 'business':
                        $ad = SellBusiness::findOrFail($Ad->local_id);
                        break;
                    case 'office':
                        $ad = SellOffice::findOrFail($Ad->local_id);
                        break;
                    case 'garage':
                        $ad = SellGarage::findOrFail($Ad->local_id);
                        break;
                    case 'land':
                        $ad = SellLand::findOrFail($Ad->local_id);
                        break;
                }
                break;
            case 'rent':
                switch($txt[1]) {
                    case 'house':
                        $ad = RentHouse::findOrFail($Ad->local_id);
                        break;
                    case 'apartment':
                        $ad = RentApartment::findOrFail($Ad->local_id);
                        break;
                    case 'country_house':
                        $ad = RentCountryHouse::findOrFail($Ad->local_id);
                        break;
                    case 'business':
                        $ad = RentBusiness::findOrFail($Ad->local_id);
                        break;
                    case 'office':
                        $ad = RentOffice::findOrFail($Ad->local_id);
                        break;
                    case 'garage':
                        $ad = RentGarage::findOrFail($Ad->local_id);
                        break;
                    case 'land':
                        $ad = RentLand::findOrFail($Ad->local_id);
                        break;
                    case 'room':
                        $ad = Room::findOrFail($Ad->local_id);
                        break;
                    case 'vacation':
                        $ad = Lodging::findOrFail($Ad->local_id);
                        break;
                }
                break;
        }

        switch($txt[0]) {
            case 'sell':
                $operation = 0;
                break;
            case 'rent':
                $operation = 1;
                break;
        }
        switch($txt[1]) {
            case 'house':
                $typology = 0;
                $ad->type = CategoryHouse::where('id',$ad->category_house_id)->pluck('name');
                break;
            case 'apartment':
                $typology = 1;
                if($ad->is_duplex)
                    $ad->type = 'Dúplex';
                elseif($ad->is_penthouse)
                    $ad->type = 'Ático';
                elseif($ad->is_studio)
                    $ad->type = 'Estudio';
                else
                    $ad->type = 'Piso';
                break;
            case 'country_house':
                $typology = 2;
                $ad->type = CategoryCountryHouse::where('id',$ad->category_country_house_id)->pluck('name');
                break;
            case 'business':
                $typology = 3;
                $ad->type = CategoryBusiness::where('id',$ad->category_business_id)->pluck('name');
                $ad->distribution = OptionBusinessDistribution::where('id',$ad->business_distribution_id)->pluck('name');
                $ad->facade = OptionBusinessFacade::where('id',$ad->business_facade_id)->pluck('name');
                $ad->location = OptionBusinessLocation::where('id',$ad->business_location_id)->pluck('name');
                break;
            case 'office':
                $typology = 4;
                $ad->type = 'Oficina';
                $ad->distribution = OptionOfficeDistribution::where('id',$ad->office_distribution_id)->pluck('name');
                break;
            case 'garage':
                $typology = 5;
                $ad->type = 'Garaje';
                $ad->garage_capacity = OptionGarageCapacity::where('id',$ad->garage_capacity_id)->pluck('name');
                break;
            case 'land':
                $typology = 6;
                $ad->type = 'Terreno';
                $ad->category_land = CategoryLand::where('id',$ad->category_land_id)->pluck('name');
                $ad->nearest_town = OptionNearestTownDistance::where('id',$ad->nearest_town_distance_id)->pluck('name');
                break;
            case 'room':
                $typology = 7;
                $ad->type = 'Habitación';
                $ad->category_room = CategoryRoom::where('id',$ad->category_room_id)->pluck('name');
                $ad->min_stay = OptionTenantMinStay::where('id',$ad->tenant_min_stay_id)->pluck('name');
                $ad->current_gender = OptionCurrentTenantsGender::where('id',$ad->current_tenants_gender_id)->pluck('name');
                $ad->gender = OptionTenantGender::where('id',$ad->tenant_gender_id)->pluck('name');
                $ad->occupation = OptionTenantOccupation::where('id',$ad->tenant_occupation_id)->pluck('name');
                $ad->sexual_orientation = OptionTenantSexualOrientation::where('id',$ad->tenant_sexual_orientation_id)->pluck('name');
                break;
            case 'vacation':
                $typology = 8;
                $ad->type = CategoryLodging::where('id',$ad->category_lodging_id)->pluck('name');
                $ad->surroundings = OptionSurroundings::where('id',$ad->surroundings_id)->pluck('name');
                $ad->min_price_per_night = \DB::select(\DB::raw("
                  SELECT MIN(t2.p_one_month) as min_price_per_night
                  FROM rent_vacation AS t1
                  LEFT JOIN vacation_season_price AS t2 ON t1.id = t2.rent_vacation_id
                  WHERE t1.id = ?;
                "),[$ad->id]);
                $ad->season_prices = SeasonPrice::where('rent_vacation_id',$ad->id)->get();
                $ad->payment_day = OptionPaymentDay::where('id',$ad->payment_day_id)->pluck('name');
                break;
        }

        return view('ad',compact('ad','operation','typology'));
    }

    public function sendContactForm()
    {
        $input = \Input::all();
        $rules = [
            'ad_ref'            => 'required|numeric',
            'contactName'       => 'required|string|max:64',
            'contactEmail'      => 'required|email|max:128',
            'contactMessage'    => 'required|string|max:1024',
        ];
        $validator = \Validator::make($input, $rules);
        if($validator->passes()) {
            \Mail::queue('ad_contact', $input, function($message) use ($input) {
                $options = \App\Constants::first();
                $message->from($options->company_email,$options->company_name)
                    ->replyTo($input['contactEmail'], $data['contactName'])
                    ->to($options->company_email,$options->company_name)
                    ->subject('Mensaje de '.$input['contactName'].' sobre anuncio #'.$input['ad_ref']);
            });
            return \Response::json('success',200);
        }
        return \Response::json('error',400);
    }
}