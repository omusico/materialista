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
use App\SeasonPrice;

class HomeController extends Controller {

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showTesterIndex()
    {
        return view('tester_index');
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
        $input = \Input::all();

        //set defaults
        if(!isset($input['operation']))
            $input['operation'] = '0';
        if(!isset($input['typology']))
            $input['typology'] = '1';
        if(!isset($input['locality']))
            $input['locality'] = 'Barcelona';
        if(!isset($input['search_type']))
            $input['search_type'] = '0';
        if(!isset($input['address']))
            $input['address'] = '';
        if(!isset($input['price-min'])||$input['price-min']=='')
            $input['price-min'] = 0;
        if(!isset($input['price-max'])||$input['price-max']=='')
            $input['price-max'] = 0;

        $price_min = ($input['price-min']) ? 'price >= '.$input['price-min'] : '1=1';
        $price_max = ($input['price-min']) ? 'price =< '.$input['price-max'] : '1=1';

        /*
         * possible search types from HOME/SEARCH:
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

        //op=1,ty=3 (rent room) equals op=2,ty=1 (share house/country house/apartment)
        if($input['operation']=='2'&&$input['typology']=='1') {
            $input['operation']='1';
            $input['typology']='3';
        }

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
                                      WHERE t1.is_new_development = 1 AND t1.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_elevator,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ? AND ? AND ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,has_elevator,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,'0' as has_elevator,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.has_elevator,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM sell_apartment AS t3
                                      WHERE t3.locality = ? AND ? AND ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Oficina' as type,area_constructed as area,hide_address,ad_id
                              FROM sell_office AS t1
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Garaje' as type,area_constructed as area,hide_address,ad_id
                              FROM sell_business AS t1
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,'Garaje' as type,`name` as garage_capacity,hide_address,ad_id
                              FROM sell_garage AS t1
                              LEFT JOIN garage_capacity AS t2 ON t1.garage_capacity_id = t2.id
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,area_total as area,'Terreno' as type,`name` as land_category,hide_address,ad_id
                              FROM sell_land AS t1
                              LEFT JOIN category_land AS t2 ON t1.category_land_id = t2.id
                              WHERE t1.locality = ? AND ? AND ?;
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
                                      WHERE t1.is_new_development = 1 AND t1.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.has_elevator,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM rent_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ? AND ? AND ?
                                ) AS t4;
                            "),[$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max,$input['locality'],$price_min,$price_max]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,has_elevator,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,'0' as has_elevator,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,'0' as has_elevator,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.locality = ? AND ? AND ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.has_elevator,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM rent_apartment AS t3
                                      WHERE t3.locality = ? AND ? AND ?
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
                              WHERE t1.locality = ? AND ? AND ?
                              GROUP BY ad_id;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '3': //room
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Habitación' as type,area_room as area,hide_address,ad_id
                              FROM rent_room AS t1
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,'Oficina' as type,area_constructed as area,hide_address,ad_id
                              FROM rent_office AS t1
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,`name` as type,area_constructed as area,hide_address,ad_id
                              FROM rent_business AS t1
                              LEFT JOIN category_business AS t2 ON t1.category_business_id = t2.id
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,'Garaje' as type,`name` as garage_capacity,hide_address,ad_id
                              FROM rent_garage AS t1
                              LEFT JOIN garage_capacity AS t2 ON t1.garage_capacity_id = t2.id
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,area_total as area,'Terreno' as type,`name` as land_category,hide_address,ad_id
                              FROM rent_land AS t1
                              LEFT JOIN category_land AS t2 ON t1.category_land_id = t2.id
                              WHERE t1.locality = ? AND ? AND ?;
                            "),[$input['locality'],$price_min,$price_max]);
                            break;
                    }
                    break;
            }
        } else {
            //Geo-locate address
            $location = Geocode::geocodeAddress($input['address']);
            if(!$location)
                return \Redirect::back();
            $locality = $location['locality'];

            //Geo-distance calculations
            $R = 6371.01; //radio de la tierra promedio (en km)
            $distance = 25; //todo: set this as a constant in config file
            $r = $distance/$R; //ángulo en radianes que equivale a recorrer $distance sobre un círculo de radio $R
            $lat_r = deg2rad($location['lat']); //en rads
            $lng_r = deg2rad($location['lng']); //en rads
            $min_lat = rad2deg($lat_r-$r); //en sexag
            $max_lat = rad2deg($lat_r+$r); //en sexag
            $delta_lng = asin(sin($r)/cos($lat_r)); //en rads
            $min_lng = rad2deg($lng_r-$delta_lng); //en sexag
            $max_lng = rad2deg($lng_r+$delta_lng); //en sexag
            $q_distance = "({$R}*ACOS(SIN({$lat_r})*SIN(RADIANS(lat))+COS({$lat_r})*COS(RADIANS(lat))*COS(RADIANS(lng)-{$lng_r})))";

            switch ($input['operation']) {
                case '0': //buy
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1
                                      AND t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1
                                      AND t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1
                                      AND t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM sell_apartment AS t3
                                      WHERE t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM sell_office AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM sell_business AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM sell_garage AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM sell_land AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1
                                      AND t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1
                                      AND t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM rent_apartment AS t3
                                      WHERE t3.is_new_development = 1
                                      AND t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,'0' as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,'0' as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM rent_apartment AS t3
                                      WHERE t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ? AND ? AND ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '2': //vacation/lodge
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,description,hide_address,ad_id,? AS distance
                              FROM rent_vacation AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '3': //room
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_room as area,hide_address,ad_id,? AS distance
                              FROM rent_room AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM rent_office AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM rent_business AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM rent_garage AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM rent_land AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ? AND ? AND ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$price_min,$price_max,$distance]);
                            break;
                    }
                    break;
            }
        }

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
        }
        $search_type = $input['search_type'];

        return view('results',compact('ads','typology','locality','search_type','input'));
    }

    public function adProfile($id)
    {
        $Ad = Ad::find($id);
        $ad = \DB::table($Ad->local_table)->where('id',$Ad->local_id)->first();

        //specific operation and typology codes for the profile page
        $txt = explode('_',$Ad->local_table,2);
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
}