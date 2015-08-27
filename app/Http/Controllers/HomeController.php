<?php namespace App\Http\Controllers;

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
        $input['locality'] = 'Sant Cugat del Vallès';
        $input['search_type'] = '0';
        //end test

        /*
         * possible search types:
         * 0 by locality (locality provided)
         * 1 by proximity (lat, lng calculated from provided address)
         *
         * possible operations from HOME:
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
                                SELECT floor,rooms,locality,route,street_number,price,has_parking_space,area,hide_address,description,`name` as type,ad_id FROM (
                                      SELECT t1.n_bedrooms as rooms,t1.locality,t1.route,t1.street_number,t1.price,t1.has_parking_space,t1.description,t1.area_constructed as area,t1.hide_address,t1.ad_id,t5.name,
                                      IF(1=1,'0','dummy') as floor
                                      FROM sell_house AS t1
                                      LEFT JOIN category_house AS t5 ON t1.category_house_id = t5.id
                                      WHERE t1.is_new_development = 1 AND t1.locality = ?
                                      UNION
                                      SELECT t2.n_bedrooms as rooms,t2.locality,t2.route,t2.street_number,t2.price,t2.has_parking_space,t2.description,t2.area_constructed as area,t2.hide_address,t2.ad_id,t6.name,
                                      IF(1=1,'0','dummy') as floor
                                      FROM sell_country_house AS t2
                                      LEFT JOIN category_country_house AS t6 ON t2.category_country_house_id = t6.id
                                      WHERE t2.is_new_development = 1 AND t2.locality = ?
                                      UNION
                                      SELECT t3.floor_number as floor,t3.n_bedrooms as rooms,t3.locality,t3.route,t3.street_number,t3.price,t3.description,t3.area_constructed as area,t3.hide_address,t3.ad_id,t3.has_parking_space,
                                      IF(is_duplex = 1, 'Dúplex', IF(is_penthouse = 1, 'Ático', IF(is_studio = 1, 'Estudio', 'Piso'))) as `name`
                                      FROM sell_apartment AS t3
                                      WHERE t3.is_new_development = 1 AND t3.locality = ?
                                ) AS t4;
                            "),[$input['locality'],$input['locality'],$input['locality']]);
                            break;
                        case '1': //house + country house + apartment

                            break;
                        case '4': //office

                            break;
                        case '5': //business

                            break;
                        case '6': //garage

                            break;
                        case '7': //land

                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development

                            break;
                        case '1': //house + country house + apartment

                            break;
                        case '2': //vacation/lodge

                            break;
                        case '3': //room

                            break;
                        case '4': //office

                            break;
                        case '5': //business

                            break;
                        case '6': //garage

                            break;
                        case '7': //land

                            break;
                    }
                    break;
            }
        } else {
            //todo: search by proximity
            //get lat lng of the given address (google geolocalization)
            //get results for the given operation and typology and order results by distance
            switch ($input['operation']) {
                case '0': //buy
                    switch ($input['typology']) {
                        case '0': //new development

                            break;
                        case '1': //house + country house + apartment

                            break;
                        case '4': //office

                            break;
                        case '5': //business

                            break;
                        case '6': //garage

                            break;
                        case '7': //land

                            break;
                    }
                    break;
                case '1': //rent
                    switch ($input['typology']) {
                        case '0': //new development

                            break;
                        case '1': //house + country house + apartment

                            break;
                        case '2': //vacation/lodge

                            break;
                        case '3': //room

                            break;
                        case '4': //office

                            break;
                        case '5': //business

                            break;
                        case '6': //garage

                            break;
                        case '7': //land

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

        return view('results',compact('ads','typology','locality','search_type'));
    }

}