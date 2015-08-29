<?php namespace App\Http\Controllers;

use App\Geocode;
use App\HomeLib;
use App\SellHouse;

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

        //test
        $input['operation'] = '0';
        $input['typology'] = '0';
        $input['locality'] = 'Girona';
        $input['search_type'] = '0';
        $input['address'] = 'Mayor 1, Barcelona';
        //end test

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
            switch ($input['operation']) {
                case '0': //buy
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1 AND t1.locality = ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ?
                                ) AS t4;
                            "),[$input['locality'],$input['locality'],$input['locality']]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.locality = ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.locality = ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM sell_apartment AS t3
                                      WHERE t3.locality = ?
                                ) AS t4;
                            "),[$input['locality'],$input['locality'],$input['locality']]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id
                              FROM sell_office AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id
                              FROM sell_business AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id
                              FROM sell_garage AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id
                              FROM sell_land AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1 AND t1.locality = ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM rent_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ?
                                ) AS t4;
                            "),[$input['locality'],$input['locality'],$input['locality']]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.locality = ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.locality = ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id
                                      FROM rent_apartment AS t3
                                      WHERE t3.locality = ?
                                ) AS t4;
                            "),[$input['locality'],$input['locality'],$input['locality']]);
                            break;
                        case '2': //vacation/lodge
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,description,hide_address,ad_id
                              FROM rent_vacation AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '3': //room
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_room as area,hide_address,ad_id
                              FROM rent_room AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id
                              FROM rent_office AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id
                              FROM rent_business AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id
                              FROM rent_garage AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id
                              FROM rent_land AS t1
                              WHERE t1.locality = ?;
                            "),[$input['locality']]);
                            break;
                    }
                    break;
            }
        } else {
            //Geo-locate address
            $location = Geocode::geocodeAddress($input['address']);
            if(!$location)
                return \Redirect::back();

            //Geo-distance calculations
            $R = 6371.01; //radio de la tierra promedio (en km)
            $distance = 50; //todo: set this as a constant in config file
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
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1
                                      AND t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1
                                      AND t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1
                                      AND t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM sell_apartment AS t3
                                      WHERE t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM sell_office AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM sell_business AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM sell_garage AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM sell_land AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1
                                      AND t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1
                                      AND t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM rent_apartment AS t3
                                      WHERE t3.is_new_development = 1
                                      AND t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '1': //house + country house + apartment
                            $ads =  \DB::select(\DB::raw("
                                SELECT rooms,floor,locality,route,street_number,price,has_parking_space,description,area,hide_address,`name` as type,ad_id,distance FROM (
                                      SELECT t1.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t5.name,t1.ad_id,? AS distance
                                      FROM rent_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,IF(1=1,'0','dummy') as floor,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t6.name,t2.ad_id,? AS distance
                                      FROM rent_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.lat >= ? AND t2.lat <= ? AND t2.lng >= ? AND t2.lng <= ?
                                      HAVING distance <= ?
                                      UNION
                                      SELECT t3.n_bedrooms as rooms,t3.floor_number as floor,t3.locality,t3.route,t3.street_number,t3.price,t3.has_parking_space,t3.description,t3.area_constructed as area,t3.hide_address,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`,t3.ad_id,? AS distance
                                      FROM rent_apartment AS t3
                                      WHERE t3.lat >= ? AND t3.lat <= ? AND t3.lng >= ? AND t3.lng <= ?
                                      HAVING distance <= ?
                                ) AS t4;
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance,
                                $q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '2': //vacation/lodge
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,description,hide_address,ad_id,? AS distance
                              FROM rent_vacation AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '3': //room
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_room as area,hide_address,ad_id,? AS distance
                              FROM rent_room AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '4': //office
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM rent_office AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '5': //business
                            $ads = \DB::select(\DB::raw("
                              SELECT floor_number as floor,locality,route,street_number,price,description,area_constructed as area,hide_address,ad_id,? AS distance
                              FROM rent_business AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '6': //garage
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM rent_garage AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
                            break;
                        case '7': //land
                            $ads = \DB::select(\DB::raw("
                              SELECT locality,route,street_number,price,description,hide_address,ad_id,? AS distance
                              FROM rent_land AS t1
                              WHERE t1.lat >= ? AND t1.lat <= ? AND t1.lng >= ? AND t1.lng <= ?
                              HAVING distance <= ?
                            "),[$q_distance,$min_lat,$max_lat,$min_lng,$max_lng,$distance]);
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
        $locality = $input['locality'];
        $search_type = $input['search_type'];

        return view('results',compact('ads','typology','locality','search_type','input'));
    }

}