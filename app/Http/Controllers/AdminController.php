<?php namespace App\Http\Controllers;

use App\Ad;
use App\AdPic;
use App\Constants;
use App\Lodging;
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
use Carbon\Carbon;

class AdminController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getNewAd() {
        $input = \Input::all();
        $operation = (isset($input['operation'])) ? $input['operation'] : '0';
        $typology = (isset($input['typology'])) ? $input['typology'] : '0';
        if($typology=='7'||$typology=='8')
            $operation = '1';

        return view('new_ad_form', compact('operation','typology'));
    }

    public function getAdsList()
    {
        $ads = Ad::all();

        return view('ads_list', compact('ads'));
    }

    public function editAd($ad_id)
    {
        $Ad = Ad::find($ad_id);
        $ad = \DB::table($Ad->local_table)->where('id',$Ad->local_id)->first();
        list($ope,$typ) = explode('_',$Ad->local_table,2);
        switch($ope) {
            case 'sell':
                $operation = 0;
                break;
            case 'rent':
                $operation = 1;
                break;
        }
        switch($typ) {
            case 'apartment':
                $typology = 0;
                break;
            case 'house':
                $typology = 1;
                break;
            case 'country_house':
                $typology = 2;
                break;
            case 'office':
                $typology = 3;
                break;
            case 'business':
                $typology = 4;
                break;
            case 'garage':
                $typology = 5;
                break;
            case 'land':
                $typology = 6;
                break;
            case 'vacation':
                $typology = 7;
                break;
            case 'room':
                $typology = 8;
                break;
        }

        return view('new_ad_form',compact('Ad','ad','operation','typology'));
    }

    public function checkAddress()
    {
        $input = \Input::all();
        $address = urlencode($input['address']); // url encode the address
        $url = "http://maps.google.es/maps/api/geocode/json?sensor=false&address={$address}"; //google maps api
        $resp_json = file_get_contents($url); // get the json response from the url
        $resp = json_decode($resp_json, true); // decode the json

        if($resp['status']!='OK') // response status will be 'OK', if able to geocode given address
            return false;

        $ans = array();
        $ans['lat'] = $resp['results'][0]['geometry']['location']['lat'];
        $ans['lng'] = $resp['results'][0]['geometry']['location']['lng'];
        $ans['formatted_address'] = $resp['results'][0]['formatted_address'];
        $ans['address_components'] = $resp['results'][0]['address_components'];

        return \Response::json($ans, 200);
    }

    public function doNewAd()
    {
        $input = \Input::all();

        //input 'corrections'
        if(isset($input['door'])) {
            if ($input['door'] == '0') {
                $input['door'] = $input['door_letter'];
            } else if ($input['door'] == '1') {
                $input['door'] = $input['door_number'];
            }
        }
        if(isset($input['has_booking'])) {
            if ($input['has_booking']=='1') {
                $input['booking'] = $input['booking-percentage'];
            } else if ($input['has_booking']=='2') {
                $input['booking'] = $input['booking-euros'];
            }
        }
        if(isset($input['has_deposit'])) {
            if ($input['has_deposit']=='1') {
                $input['deposit'] = $input['deposit-percentage'];
            } else if ($input['has_deposit']=='2') {
                $input['deposit'] = $input['deposit-euros'];
            }
        }

        //create new Ad ID
        $newAd = Ad::create();
        $input['ad_id'] = $newAd->id;

        //associate pictures to the new Ad ID
        foreach($input as $key => $value) {
            $exp_key = explode('_', $key);
            if($exp_key[0] == 'pictures'){
                $pictures[] = ['filename'=>$value];
            }
        }
        if(isset($pictures)){
            foreach($pictures as $picture)
                AdPic::create([
                    'filename' => $picture['filename'],
                    'ad_id'    => $input['ad_id']
                ]);
        }

        //save all the details of the ad in its specific table
        switch ($input['operation']) {
            case '0': //sell
                switch ($input['typology']) {
                    case '0': //apartment
                        $new = SellApartment::create($input);
                        $table = 'sell_apartment';
                        break;
                    case '1': //house
                        $new = SellHouse::create($input);
                        $table = 'sell_house';
                        break;
                    case '2': //country house
                        $new = SellCountryHouse::create($input);
                        $table = 'sell_country_house';
                        break;
                    case '3': //office
                        $new = SellOffice::create($input);
                        $table = 'sell_office';
                        break;
                    case '4': //business
                        $new = SellBusiness::create($input);
                        $table = 'sell_business';
                        break;
                    case '5': //garage
                        $new = SellGarage::create($input);
                        $table = 'sell_garage';
                        break;
                    case '6': //land
                        $new = SellLand::create($input);
                        $table = 'sell_land';
                        break;
                }
                break;
            case '1': //rent
                switch ($input['typology']) {
                    case '0': //apartment
                        $new = RentApartment::create($input);
                        $table = 'rent_apartment';
                        break;
                    case '1': //house
                        $new = RentHouse::create($input);
                        $table = 'rent_house';
                        break;
                    case '2': //country house
                        $new = RentCountryHouse::create($input);
                        $table = 'rent_country_house';
                        break;
                    case '3': //office
                        $new = RentOffice::create($input);
                        $table = 'rent_office';
                        break;
                    case '4': //business
                        $new = RentBusiness::create($input);
                        $table = 'rent_business';
                        break;
                    case '5': //garage
                        $new = RentGarage::create($input);
                        $table = 'rent_garage';
                        break;
                    case '6': //land
                        $new = RentLand::create($input);
                        $table = 'rent_land';
                        break;
                    case '7': //vacation (lodging)
                        $new = Lodging::create($input);
                        $table = 'rent_vacation';
                        //associate prices to new lodging
                        foreach($input as $key => $value) {
                            $exp_key = explode('-', $key);
                            if($exp_key[0] == 'n_season'){
                                SeasonPrice::create([
                                    'n_season'                  => $value,
                                    'from_date'                 => Carbon::createFromFormat('d/m/Y',$input['from_date-'.$value]),
                                    'to_date'                   => Carbon::createFromFormat('d/m/Y',$input['to_date-'.$value]),
                                    'p_one_night'               => $input['p_one_night-'.$value],
                                    'p_weekend_night'           => $input['p_weekend_night-'.$value],
                                    'p_one_week'                => $input['p_one_week-'.$value],
                                    'p_half_month'              => $input['p_half_month-'.$value],
                                    'p_one_month'               => $input['p_one_month-'.$value],
                                    'p_extra_guest_per_night'   => $input['p_extra_guest_per_night-'.$value],
                                    'n_min_nights'              => $input['n_min_nights-'.$value],
                                    'rent_vacation_id'          => $new->id
                                ]);
                            }
                        }
                        break;
                    case '8': //room
                        $new = Room::create($input);
                        $table = 'rent_room';
                        break;
                }
                break;
        }

        //save local table and ID as ad fields
        if(isset($new)&&isset($table)) {
            $newAd->local_table = $table;
            $newAd->local_id = $new->id;
            $newAd->save();
        }

        //return success to admin dashboard
        if(isset($new->id))
            return redirect('dashboard')
                ->with('success',['Stitle'=>'Nuevo anuncio','Smsg'=>'Su nuevo anuncio ha sido creado satisfactoriamente.']);
        return redirect('dashboard')
            ->with('error', ['Etitle'=>'Nuevo anuncio', 'Emsg'=>'Se produjo un error al tratar de crear un nuevo anuncio. Si el problema persiste póngase en contacto con el Servicio Técnico de la aplicación.']);
    }

    public function doEditAd()
    {
        $input = \Input::all();

        //input 'corrections'
        if(isset($input['door'])) {
            if ($input['door'] == '0') {
                $input['door'] = $input['door_letter'];
            } else if ($input['door'] == '1') {
                $input['door'] = $input['door_number'];
            }
        }
        if(isset($input['has_booking'])) {
            if ($input['has_booking']=='1') {
                $input['booking'] = $input['booking-percentage'];
            } else if ($input['has_booking']=='2') {
                $input['booking'] = $input['booking-euros'];
            }
        }
        if(isset($input['has_deposit'])) {
            if ($input['has_deposit']=='1') {
                $input['deposit'] = $input['deposit-percentage'];
            } else if ($input['has_deposit']=='2') {
                $input['deposit'] = $input['deposit-euros'];
            }
        }

        //Find old Ad
        $Ad = Ad::findOrFail($input['ad_id']);

        //Delete old pics
        if($Ad->pics->count())
            $Ad->pics()->delete();

        //Associate new pictures with the Ad
        foreach($input as $key => $value) {
            $exp_key = explode('_', $key);
            if($exp_key[0] == 'pictures'){
                $pictures[] = ['filename'=>$value];
            }
        }
        if(isset($pictures)) {
            foreach($pictures as $picture)
                AdPic::create([
                    'filename' => $picture['filename'],
                    'ad_id'    => $input['ad_id']
                ]);
        }

        //Save the new info
        switch ($input['operation']) {
            case '0': //sell
                switch ($input['typology']) {
                    case '0': //apartment
                        $old = SellApartment::find($input['local_id']);
                        $old->price = $input['price'];
                        $old->community_cost = $input['community_cost'];
                        $old->is_bank_agency = (isset($input['is_bank_agency'])&&$input['is_bank_agency']) ? true : false;
                        $old->is_state_subsidized = (isset($input['is_state_subsidized'])&&$input['is_state_subsidized']) ? true : false;
                        $old->is_new_development = (isset($input['is_new_development'])&&$input['is_new_development']) ? true : false;
                        $old->is_new_development_finished = (isset($input['is_new_development_finished'])&&$input['is_new_development_finished']) ? true : false;
                        $old->is_rent_to_own = (isset($input['is_rent_to_own'])&&$input['is_rent_to_own']) ? true : false;
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->is_last_floor = (isset($input['is_last_floor'])&&$input['is_last_floor']) ? true : false;
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->is_regular = (isset($input['is_regular'])&&$input['is_regular']) ? true : false;
                        $old->is_penthouse = (isset($input['is_penthouse'])&&$input['is_penthouse']) ? true : false;
                        $old->is_duplex = (isset($input['is_duplex'])&&$input['is_duplex']) ? true : false;
                        $old->is_studio = (isset($input['is_studio'])&&$input['is_studio']) ? true : false;
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->is_exterior = (isset($input['is_exterior'])&&$input['is_exterior']) ? true : false;
                        $old->has_elevator = (isset($input['has_elevator'])&&$input['has_elevator']) ? true : false;
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->faces_north = (isset($input['faces_north'])&&$input['faces_north']) ? true : false;
                        $old->faces_south = (isset($input['faces_south'])&&$input['faces_south']) ? true : false;
                        $old->faces_east = (isset($input['faces_east'])&&$input['faces_east']) ? true : false;
                        $old->faces_west = (isset($input['faces_west'])&&$input['faces_west']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_box_room = (isset($input['has_box_room'])&&$input['has_box_room']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_swimming_pool = (isset($input['has_swimming_pool'])&&$input['has_swimming_pool']) ? true : false;
                        $old->has_garden = (isset($input['has_garden'])&&$input['has_garden']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '1': //house
                        $old = SellHouse::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->community_cost = $input['community_cost'];
                        $old->is_bank_agency = (isset($input['is_bank_agency'])&&$input['is_bank_agency']) ? true : false;
                        $old->is_state_subsidized = (isset($input['is_state_subsidized'])&&$input['is_state_subsidized']) ? true : false;
                        $old->is_new_development = (isset($input['is_new_development'])&&$input['is_new_development']) ? true : false;
                        $old->is_new_development_finished = (isset($input['is_new_development_finished'])&&$input['is_new_development_finished']) ? true : false;
                        $old->is_rent_to_own = (isset($input['is_rent_to_own'])&&$input['is_rent_to_own']) ? true : false;
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->category_house_id = $input['category_house_id'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->area_land = $input['area_land'];
                        $old->n_floors = $input['n_floors'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->faces_north = (isset($input['faces_north'])&&$input['faces_north']) ? true : false;
                        $old->faces_south = (isset($input['faces_south'])&&$input['faces_south']) ? true : false;
                        $old->faces_east = (isset($input['faces_east'])&&$input['faces_east']) ? true : false;
                        $old->faces_west = (isset($input['faces_west'])&&$input['faces_west']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_box_room = (isset($input['has_box_room'])&&$input['has_box_room']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_swimming_pool = (isset($input['has_swimming_pool'])&&$input['has_swimming_pool']) ? true : false;
                        $old->has_garden = (isset($input['has_garden'])&&$input['has_garden']) ? true : false;
                        $old->has_fireplace = (isset($input['has_fireplace'])&&$input['has_fireplace']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '2': //country house
                        $old = SellCountryHouse::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->community_cost = $input['community_cost'];
                        $old->is_bank_agency = (isset($input['is_bank_agency'])&&$input['is_bank_agency']) ? true : false;
                        $old->is_state_subsidized = (isset($input['is_state_subsidized'])&&$input['is_state_subsidized']) ? true : false;
                        $old->is_new_development = (isset($input['is_new_development'])&&$input['is_new_development']) ? true : false;
                        $old->is_new_development_finished = (isset($input['is_new_development_finished'])&&$input['is_new_development_finished']) ? true : false;
                        $old->is_rent_to_own = (isset($input['is_rent_to_own'])&&$input['is_rent_to_own']) ? true : false;
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->category_country_house_id = $input['category_country_house_id'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->area_land = $input['area_land'];
                        $old->n_floors = $input['n_floors'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->faces_north = (isset($input['faces_north'])&&$input['faces_north']) ? true : false;
                        $old->faces_south = (isset($input['faces_south'])&&$input['faces_south']) ? true : false;
                        $old->faces_east = (isset($input['faces_east'])&&$input['faces_east']) ? true : false;
                        $old->faces_west = (isset($input['faces_west'])&&$input['faces_west']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_box_room = (isset($input['has_box_room'])&&$input['has_box_room']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_swimming_pool = (isset($input['has_swimming_pool'])&&$input['has_swimming_pool']) ? true : false;
                        $old->has_garden = (isset($input['has_garden'])&&$input['has_garden']) ? true : false;
                        $old->has_fireplace = (isset($input['has_fireplace'])&&$input['has_fireplace']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '3': //office
                        $old = SellOffice::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->community_cost = $input['community_cost'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->area_min_for_sale = $input['area_min_for_sale'];
                        $old->n_floors = $input['n_floors'];
                        $old->has_offices_only = (isset($input['has_offices_only'])&&$input['has_offices_only']) ? true : false;
                        $old->office_distribution_id = $input['office_distribution_id'];
                        $old->n_restrooms = $input['n_restrooms'];
                        $old->has_bathrooms = (isset($input['has_bathrooms'])&&$input['has_bathrooms']) ? true : false;
                        $old->has_bathrooms_inside = (isset($input['has_bathrooms_inside'])&&$input['has_bathrooms_inside']) ? true : false;
                        $old->is_exterior = (isset($input['is_exterior'])&&$input['is_exterior']) ? true : false;
                        $old->n_elevators = $input['n_elevators'];
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->n_parking_spaces = $input['n_parking_spaces'];
                        $old->has_steel_door = (isset($input['has_steel_door'])&&$input['has_steel_door']) ? true : false;
                        $old->has_security_system = (isset($input['has_security_system'])&&$input['has_security_system']) ? true : false;
                        $old->has_access_control = (isset($input['has_access_control'])&&$input['has_access_control']) ? true : false;
                        $old->has_fire_detectors = (isset($input['has_fire_detectors'])&&$input['has_fire_detectors']) ? true : false;
                        $old->has_fire_extinguishers = (isset($input['has_fire_extinguishers'])&&$input['has_fire_extinguishers']) ? true : false;
                        $old->has_fire_sprinklers = (isset($input['has_fire_sprinklers'])&&$input['has_fire_sprinklers']) ? true : false;
                        $old->has_fireproof_doors = (isset($input['has_fireproof_doors'])&&$input['has_fireproof_doors']) ? true : false;
                        $old->has_emergency_lights = (isset($input['has_emergency_lights'])&&$input['has_emergency_lights']) ? true : false;
                        $old->has_doorman = (isset($input['has_doorman'])&&$input['has_doorman']) ? true : false;
                        $old->has_air_conditioning_preinstallation = (isset($input['has_air_conditioning_preinstallation'])&&$input['has_air_conditioning_preinstallation']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_heating = (isset($input['has_heating'])&&$input['has_heating']) ? true : false;
                        $old->has_hot_water = (isset($input['has_hot_water'])&&$input['has_hot_water']) ? true : false;
                        $old->has_kitchen = (isset($input['has_kitchen'])&&$input['has_kitchen']) ? true : false;
                        $old->has_archive = (isset($input['has_archive'])&&$input['has_archive']) ? true : false;
                        $old->has_double_windows = (isset($input['has_double_windows'])&&$input['has_double_windows']) ? true : false;
                        $old->has_suspended_ceiling = (isset($input['has_suspended_ceiling'])&&$input['has_suspended_ceiling']) ? true : false;
                        $old->has_suspended_floor = (isset($input['has_suspended_floor'])&&$input['has_suspended_floor']) ? true : false;
                        $old->is_handicapped_adapted = (isset($input['is_handicapped_adapted'])&&$input['is_handicapped_adapted']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '4': //business
                        $old = SellBusiness::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->community_cost = $input['community_cost'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->category_business_id = $input['category_business_id'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->business_distribution_id = $input['business_distribution_id'];
                        $old->business_facade_id = $input['business_facade_id'];
                        $old->n_shop_windows = $input['n_shop_windows'];
                        $old->business_location_id = $input['business_location_id'];
                        $old->n_floors = $input['n_floors'];
                        $old->n_restrooms = $input['n_restrooms'];
                        $old->last_activity = $input['last_activity'];
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->has_archive = (isset($input['has_archive'])&&$input['has_archive']) ? true : false;
                        $old->has_smoke_extractor = (isset($input['has_smoke_extractor'])&&$input['has_smoke_extractor']) ? true : false;
                        $old->has_fully_equipped_kitchen = (isset($input['has_fully_equipped_kitchen'])&&$input['has_fully_equipped_kitchen']) ? true : false;
                        $old->has_steel_door = (isset($input['has_steel_door'])&&$input['has_steel_door']) ? true : false;
                        $old->has_alarm = (isset($input['has_alarm'])&&$input['has_alarm']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_heating = (isset($input['has_heating'])&&$input['has_heating']) ? true : false;
                        $old->has_security_camera = (isset($input['has_security_camera'])&&$input['has_security_camera']) ? true : false;
                        $old->is_corner_located = (isset($input['is_corner_located'])&&$input['is_corner_located']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '5': //garage
                        $old = SellGarage::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->community_cost = $input['community_cost'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->garage_capacity_id = $input['garage_capacity_id'];
                        $old->is_covered = (isset($input['is_covered'])&&$input['is_covered']) ? true : false;
                        $old->has_automatic_door = (isset($input['has_automatic_door'])&&$input['has_automatic_door']) ? true : false;
                        $old->has_lift = (isset($input['has_lift'])&&$input['has_lift']) ? true : false;
                        $old->has_alarm = (isset($input['has_alarm'])&&$input['has_alarm']) ? true : false;
                        $old->has_security_camera = (isset($input['has_security_camera'])&&$input['has_security_camera']) ? true : false;
                        $old->has_security_guard = (isset($input['has_security_guard'])&&$input['has_security_guard']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '6': //land
                        $old = SellLand::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->category_land_id = $input['category_land_id'];
                        $old->area_total = $input['area_total'];
                        $old->area_building_land = $input['area_building_land'];
                        $old->area_min_for_sale = $input['area_min_for_sale'];
                        $old->is_classified_residential_block = (isset($input['is_classified_residential_block'])&&$input['is_classified_residential_block']) ? true : false;;
                        $old->is_classified_residential_house = (isset($input['is_classified_residential_house'])&&$input['is_classified_residential_house']) ? true : false;;
                        $old->is_classified_office = (isset($input['is_classified_office'])&&$input['is_classified_office']) ? true : false;;
                        $old->is_classified_commercial = (isset($input['is_classified_commercial'])&&$input['is_classified_commercial']) ? true : false;;
                        $old->is_classified_hotel = (isset($input['is_classified_hotel'])&&$input['is_classified_hotel']) ? true : false;;
                        $old->is_classified_industrial = (isset($input['is_classified_industrial'])&&$input['is_classified_industrial']) ? true : false;;
                        $old->is_classified_public_service = (isset($input['is_classified_public_service'])&&$input['is_classified_public_service']) ? true : false;;
                        $old->is_classified_others = (isset($input['is_classified_others'])&&$input['is_classified_others']) ? true : false;;
                        $old->max_floors_allowed = $input['max_floors_allowed'];
                        $old->has_road_access = (isset($input['has_road_access'])&&$input['has_road_access']) ? true : false;;
                        $old->nearest_town_distance_id = $input['nearest_town_distance_id'];
                        $old->has_water = (isset($input['has_water'])&&$input['has_water']) ? true : false;;
                        $old->has_electricity = (isset($input['has_electricity'])&&$input['has_electricity']) ? true : false;;
                        $old->has_sewer_system = (isset($input['has_sewer_system'])&&$input['has_sewer_system']) ? true : false;;
                        $old->has_natural_gas = (isset($input['has_natural_gas'])&&$input['has_natural_gas']) ? true : false;;
                        $old->has_street_lighting = (isset($input['has_street_lighting'])&&$input['has_street_lighting']) ? true : false;;
                        $old->has_sidewalks = (isset($input['has_sidewalks'])&&$input['has_sidewalks']) ? true : false;;
                        $old->description = $input['description'];
                        break;
                }
                break;
            case '1': //rent
                switch ($input['typology']) {
                    case '0': //apartment
                        $old = RentApartment::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->is_bank_agency = (isset($input['is_bank_agency'])&&$input['is_bank_agency']) ? true : false;
                        $old->is_state_subsidized = (isset($input['is_state_subsidized'])&&$input['is_state_subsidized']) ? true : false;
                        $old->is_new_development = (isset($input['is_new_development'])&&$input['is_new_development']) ? true : false;
                        $old->is_new_development_finished = (isset($input['is_new_development_finished'])&&$input['is_new_development_finished']) ? true : false;
                        $old->is_rent_to_own = (isset($input['is_rent_to_own'])&&$input['is_rent_to_own']) ? true : false;
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->is_last_floor = (isset($input['is_last_floor'])&&$input['is_last_floor']) ? true : false;
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->is_regular = (isset($input['is_regular'])&&$input['is_regular']) ? true : false;
                        $old->is_penthouse = (isset($input['is_penthouse'])&&$input['is_penthouse']) ? true : false;
                        $old->is_duplex = (isset($input['is_duplex'])&&$input['is_duplex']) ? true : false;
                        $old->is_studio = (isset($input['is_studio'])&&$input['is_studio']) ? true : false;
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->is_exterior = (isset($input['is_exterior'])&&$input['is_exterior']) ? true : false;
                        $old->has_equipped_kitchen = (isset($input['has_equipped_kitchen'])&&$input['has_equipped_kitchen']) ? true : false;
                        $old->has_furniture = (isset($input['has_furniture'])&&$input['has_furniture']) ? true : false;
                        $old->has_elevator = (isset($input['has_elevator'])&&$input['has_elevator']) ? true : false;
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->faces_north = (isset($input['faces_north'])&&$input['faces_north']) ? true : false;
                        $old->faces_south = (isset($input['faces_south'])&&$input['faces_south']) ? true : false;
                        $old->faces_east = (isset($input['faces_east'])&&$input['faces_east']) ? true : false;
                        $old->faces_west = (isset($input['faces_west'])&&$input['faces_west']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_box_room = (isset($input['has_box_room'])&&$input['has_box_room']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_swimming_pool = (isset($input['has_swimming_pool'])&&$input['has_swimming_pool']) ? true : false;
                        $old->has_garden = (isset($input['has_garden'])&&$input['has_garden']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '1': //house
                        $old = RentHouse::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->is_bank_agency = (isset($input['is_bank_agency'])&&$input['is_bank_agency']) ? true : false;
                        $old->is_state_subsidized = (isset($input['is_state_subsidized'])&&$input['is_state_subsidized']) ? true : false;
                        $old->is_new_development = (isset($input['is_new_development'])&&$input['is_new_development']) ? true : false;
                        $old->is_new_development_finished = (isset($input['is_new_development_finished'])&&$input['is_new_development_finished']) ? true : false;
                        $old->is_rent_to_own = (isset($input['is_rent_to_own'])&&$input['is_rent_to_own']) ? true : false;
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->category_house_id = $input['category_house_id'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->area_land = $input['area_land'];
                        $old->n_floors = $input['n_floors'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->has_equipped_kitchen = (isset($input['has_equipped_kitchen'])&&$input['has_equipped_kitchen']) ? true : false;
                        $old->has_furniture = (isset($input['has_furniture'])&&$input['has_furniture']) ? true : false;
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->faces_north = (isset($input['faces_north'])&&$input['faces_north']) ? true : false;
                        $old->faces_south = (isset($input['faces_south'])&&$input['faces_south']) ? true : false;
                        $old->faces_east = (isset($input['faces_east'])&&$input['faces_east']) ? true : false;
                        $old->faces_west = (isset($input['faces_west'])&&$input['faces_west']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_box_room = (isset($input['has_box_room'])&&$input['has_box_room']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_fireplace = (isset($input['has_fireplace'])&&$input['has_fireplace']) ? true : false;
                        $old->has_swimming_pool = (isset($input['has_swimming_pool'])&&$input['has_swimming_pool']) ? true : false;
                        $old->has_garden = (isset($input['has_garden'])&&$input['has_garden']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '2': //country house
                        $old = RentCountryHouse::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->is_bank_agency = (isset($input['is_bank_agency'])&&$input['is_bank_agency']) ? true : false;
                        $old->is_state_subsidized = (isset($input['is_state_subsidized'])&&$input['is_state_subsidized']) ? true : false;
                        $old->is_new_development = (isset($input['is_new_development'])&&$input['is_new_development']) ? true : false;
                        $old->is_new_development_finished = (isset($input['is_new_development_finished'])&&$input['is_new_development_finished']) ? true : false;
                        $old->is_rent_to_own = (isset($input['is_rent_to_own'])&&$input['is_rent_to_own']) ? true : false;
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->category_country_house_id = $input['category_country_house_id'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->area_land = $input['area_land'];
                        $old->n_floors = $input['n_floors'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->has_equipped_kitchen = (isset($input['has_equipped_kitchen'])&&$input['has_equipped_kitchen']) ? true : false;
                        $old->has_furniture = (isset($input['has_furniture'])&&$input['has_furniture']) ? true : false;
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->faces_north = (isset($input['faces_north'])&&$input['faces_north']) ? true : false;
                        $old->faces_south = (isset($input['faces_south'])&&$input['faces_south']) ? true : false;
                        $old->faces_east = (isset($input['faces_east'])&&$input['faces_east']) ? true : false;
                        $old->faces_west = (isset($input['faces_west'])&&$input['faces_west']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_box_room = (isset($input['has_box_room'])&&$input['has_box_room']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_fireplace = (isset($input['has_fireplace'])&&$input['has_fireplace']) ? true : false;
                        $old->has_swimming_pool = (isset($input['has_swimming_pool'])&&$input['has_swimming_pool']) ? true : false;
                        $old->has_garden = (isset($input['has_garden'])&&$input['has_garden']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '3': //office
                        $old = RentOffice::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->area_min_for_sale = $input['area_min_for_sale'];
                        $old->n_floors = $input['n_floors'];
                        $old->has_offices_only = (isset($input[''])&&$input['']) ? true : false;
                        $old->office_distribution_id = $input['office_distribution_id'];
                        $old->n_restrooms = $input['n_restrooms'];
                        $old->has_bathrooms = (isset($input['has_bathrooms'])&&$input['has_bathrooms']) ? true : false;
                        $old->has_bathrooms_inside = (isset($input['has_bathrooms_inside'])&&$input['has_bathrooms_inside']) ? true : false;
                        $old->is_exterior = (isset($input['is_exterior'])&&$input['is_exterior']) ? true : false;
                        $old->n_elevators = $input['n_elevators'];
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->n_parking_spaces = $input['n_parking_spaces'];
                        $old->has_steel_door = (isset($input['has_steel_door'])&&$input['has_steel_door']) ? true : false;
                        $old->has_security_system = (isset($input['has_security_system'])&&$input['has_security_system']) ? true : false;
                        $old->has_access_control = (isset($input['has_access_control'])&&$input['has_access_control']) ? true : false;
                        $old->has_fire_detectors = (isset($input['has_fire_detectors'])&&$input['has_fire_detectors']) ? true : false;
                        $old->has_fire_extinguishers = (isset($input['has_fire_extinguishers'])&&$input['has_fire_extinguishers']) ? true : false;
                        $old->has_fire_sprinklers = (isset($input['has_fire_sprinklers'])&&$input['has_fire_sprinklers']) ? true : false;
                        $old->has_fireproof_doors = (isset($input['has_fireproof_doors'])&&$input['has_fireproof_doors']) ? true : false;
                        $old->has_emergency_lights = (isset($input['has_emergency_lights'])&&$input['has_emergency_lights']) ? true : false;
                        $old->has_doorman = (isset($input['has_doorman'])&&$input['has_doorman']) ? true : false;
                        $old->has_air_conditioning_preinstallation = (isset($input['has_air_conditioning_preinstallation'])&&$input['has_air_conditioning_preinstallation']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_heating = (isset($input['has_heating'])&&$input['has_heating']) ? true : false;
                        $old->has_hot_water = (isset($input['has_hot_water'])&&$input['has_hot_water']) ? true : false;
                        $old->has_kitchen = (isset($input['has_kitchen'])&&$input['has_kitchen']) ? true : false;
                        $old->has_archive = (isset($input['has_archive'])&&$input['has_archive']) ? true : false;
                        $old->has_double_windows = (isset($input['has_double_windows'])&&$input['has_double_windows']) ? true : false;
                        $old->has_suspended_ceiling = (isset($input['has_suspended_ceiling'])&&$input['has_suspended_ceiling']) ? true : false;
                        $old->has_suspended_floor = (isset($input['has_suspended_floor'])&&$input['has_suspended_floor']) ? true : false;
                        $old->is_handicapped_adapted = (isset($input['is_handicapped_adapted'])&&$input['is_handicapped_adapted']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '4': //business
                        $old = RentBusiness::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->is_transfer = (isset($input['is_transfer'])&&$input['is_transfer']) ? true : false;
                        $old->deposit = $input['deposit'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->category_business_id = $input['category_business_id'];
                        $old->needs_restoration = (isset($input['needs_restoration'])&&$input['needs_restoration']) ? true : false;
                        $old->area_constructed = $input['area_constructed'];
                        $old->area_usable = $input['area_usable'];
                        $old->business_distribution_id = $input['business_distribution_id'];
                        $old->business_facade_id = $input['business_facade_id'];
                        $old->n_shop_windows = $input['n_shop_windows'];
                        $old->business_location_id = $input['business_location_id'];
                        $old->n_floors = $input['n_floors'];
                        $old->n_restrooms = $input['n_restrooms'];
                        $old->last_activity = $input['last_activity'];
                        $old->energy_certification_id = $input['energy_certification_id'];
                        $old->energy_performance = $input['energy_performance'];
                        $old->has_archive = (isset($input['has_archive'])&&$input['has_archive']) ? true : false;
                        $old->has_smoke_extractor = (isset($input['has_smoke_extractor'])&&$input['has_smoke_extractor']) ? true : false;
                        $old->has_fully_equipped_kitchen = (isset($input['has_fully_equipped_kitchen'])&&$input['has_fully_equipped_kitchen']) ? true : false;
                        $old->has_steel_door = (isset($input['has_steel_door'])&&$input['has_steel_door']) ? true : false;
                        $old->has_alarm = (isset($input['has_alarm'])&&$input['has_alarm']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_heating = (isset($input['has_heating'])&&$input['has_heating']) ? true : false;
                        $old->has_security_camera = (isset($input['has_security_camera'])&&$input['has_security_camera']) ? true : false;
                        $old->is_corner_located = (isset($input['is_corner_located'])&&$input['is_corner_located']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '5': //garage
                        $old = RentGarage::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->garage_capacity_id = $input['garage_capacity_id'];
                        $old->is_covered = (isset($input['is_covered'])&&$input['is_covered']) ? true : false;
                        $old->has_automatic_door = (isset($input['has_automatic_door'])&&$input['has_automatic_door']) ? true : false;
                        $old->has_lift = (isset($input['has_lift'])&&$input['has_lift']) ? true : false;
                        $old->has_alarm = (isset($input['has_alarm'])&&$input['has_alarm']) ? true : false;
                        $old->has_security_camera = (isset($input['has_security_camera'])&&$input['has_security_camera']) ? true : false;
                        $old->has_security_guard = (isset($input['has_security_guard'])&&$input['has_security_guard']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '6': //land
                        $old = RentLand::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->residential_area = $input['residential_area'];
                        $old->category_land_id = $input['category_land_id'];
                        $old->area_total = $input['area_total'];
                        $old->area_building_land = $input['area_building_land'];
                        $old->area_min_for_sale = $input['area_min_for_sale'];
                        $old->is_classified_residential_block = (isset($input['is_classified_residential_block'])&&$input['is_classified_residential_block']) ? true : false;
                        $old->is_classified_residential_house = (isset($input['is_classified_residential_house'])&&$input['is_classified_residential_house']) ? true : false;
                        $old->is_classified_office = (isset($input['is_classified_office'])&&$input['is_classified_office']) ? true : false;
                        $old->is_classified_commercial = (isset($input['is_classified_commercial'])&&$input['is_classified_commercial']) ? true : false;
                        $old->is_classified_hotel = (isset($input['is_classified_hotel'])&&$input['is_classified_hotel']) ? true : false;
                        $old->is_classified_industrial = (isset($input['is_classified_industrial'])&&$input['is_classified_industrial']) ? true : false;
                        $old->is_classified_public_service = (isset($input['is_classified_public_service'])&&$input['is_classified_public_service']) ? true : false;
                        $old->is_classified_others = (isset($input['is_classified_others'])&&$input['is_classified_others']) ? true : false;
                        $old->max_floors_allowed = $input['max_floors_allowed'];
                        $old->has_road_access = (isset($input['has_road_access'])&&$input['has_road_access']) ? true : false;
                        $old->nearest_town_distance_id = $input['nearest_town_distance_id'];
                        $old->has_water = (isset($input['has_water'])&&$input['has_water']) ? true : false;
                        $old->has_electricity = (isset($input['has_electricity'])&&$input['has_electricity']) ? true : false;
                        $old->has_sewer_system = (isset($input['has_sewer_system'])&&$input['has_sewer_system']) ? true : false;
                        $old->has_natural_gas = (isset($input['has_natural_gas'])&&$input['has_natural_gas']) ? true : false;
                        $old->has_street_lighting = (isset($input['has_street_lighting'])&&$input['has_street_lighting']) ? true : false;
                        $old->has_sidewalks = (isset($input['has_sidewalks'])&&$input['has_sidewalks']) ? true : false;
                        $old->description = $input['description'];
                        break;
                    case '7': //vacation (lodging)
                        $old = Lodging::findOrFail($input['local_id']);
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->is_last_floor = (isset($input['is_last_floor'])&&$input['is_last_floor']) ? true : false;
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->surroundings_id = $input['surroundings_id'];
                        $old->category_lodging_id = $input['category_lodging_id'];
                        $old->has_multiple_lodgings = (isset($input['has_multiple_lodgings'])&&$input['has_multiple_lodgings']) ? true : false;
                        $old->area_total = $input['area_total'];
                        $old->area_garden = $input['area_garden'];
                        $old->area_terrace = $input['area_terrace'];
                        $old->is_american_kitchen = (isset($input['is_american_kitchen'])&&$input['is_american_kitchen']) ? true : false;
                        $old->distance_to_beach = $input['distance_to_beach'];
                        $old->distance_to_town_center = $input['distance_to_town_center'];
                        $old->distance_to_ski_area = $input['distance_to_ski_area'];
                        $old->distance_to_golf_course = $input['distance_to_golf_course'];
                        $old->distance_to_airport = $input['distance_to_airport'];
                        $old->distance_to_supermarket = $input['distance_to_supermarket'];
                        $old->distance_to_river_or_lake = $input['distance_to_river_or_lake'];
                        $old->distance_to_marina = $input['distance_to_marina'];
                        $old->distance_to_horse_riding_area = $input['distance_to_horse_riding_area'];
                        $old->distance_to_scuba_diving_area = $input['distance_to_scuba_diving_area'];
                        $old->distance_to_train_station = $input['distance_to_train_station'];
                        $old->distance_to_bus_station = $input['distance_to_bus_station'];
                        $old->distance_to_hospital = $input['distance_to_hospital'];
                        $old->distance_to_hiking_area = $input['distance_to_hiking_area'];
                        $old->n_double_bedroom = $input['n_double_bedroom'];
                        $old->n_two_beds_room = $input['n_two_beds_room'];
                        $old->n_single_bed_room = $input['n_single_bed_room'];
                        $old->n_three_beds_room = $input['n_three_beds_room'];
                        $old->n_four_beds_room = $input['n_four_beds_room'];
                        $old->n_sofa_bed = $input['n_sofa_bed'];
                        $old->n_double_sofa_bed = $input['n_double_sofa_bed'];
                        $old->n_extra_bed = $input['n_extra_bed'];
                        $old->min_capacity = $input['min_capacity'];
                        $old->max_capacity = $input['max_capacity'];
                        $old->has_booking = $input['has_booking'];
                        $old->booking = (isset($input['has_booking'])&&$input['has_booking']) ? $input['booking'] : null;
                        $old->has_deposit = $input['has_deposit'];
                        $old->deposit = (isset($input['has_deposit'])&&$input['has_deposit']) ? $input['deposit'] : null;
                        $old->payment_day_id = $input['payment_day_id'];
                        $old->n_days_before = (isset($input['n_days_before'])) ? $input['n_days_before'] : null;
                        $old->has_cleaning = (isset($input['has_cleaning'])&&$input['has_cleaning']) ? true : false;
                        $old->cleaning = (isset($input['has_cleaning'])&&!$input['has_cleaning']&&isset($input['cleaning'])) ? $input['cleaning'] : null;
                        $old->has_included_towels = (isset($input['has_included_towels'])&&$input['has_included_towels']) ? true : false;
                        $old->has_included_expenses = (isset($input['has_included_expenses'])&&$input['has_included_expenses']) ? true : false;
                        $old->accepts_cash = (isset($input['accepts_cash'])&&$input['accepts_cash']) ? true : false;
                        $old->accepts_transfer = (isset($input['accepts_transfer'])&&$input['accepts_transfer']) ? true : false;
                        $old->accepts_credit_card = (isset($input['accepts_credit_card'])&&$input['accepts_credit_card']) ? true : false;
                        $old->accepts_paypal = (isset($input['accepts_paypal'])&&$input['accepts_paypal']) ? true : false;
                        $old->accepts_check = (isset($input['accepts_check'])&&$input['accepts_check']) ? true : false;
                        $old->accepts_western_union = (isset($input['accepts_western_union'])&&$input['accepts_western_union']) ? true : false;
                        $old->accepts_money_gram = (isset($input['accepts_money_gram'])&&$input['accepts_money_gram']) ? true : false;
                        $old->has_barbecue = (isset($input['has_barbecue'])&&$input['has_barbecue']) ? true : false;
                        $old->has_terrace = (isset($input['has_terrace'])&&$input['has_terrace']) ? true : false;
                        $old->has_private_swimming_pool = (isset($input['has_private_swimming_pool'])&&$input['has_private_swimming_pool']) ? true : false;
                        $old->has_shared_swimming_pool = (isset($input['has_shared_swimming_pool'])&&$input['has_shared_swimming_pool']) ? true : false;
                        $old->has_indoor_swimming_pool = (isset($input['has_indoor_swimming_pool'])&&$input['has_indoor_swimming_pool']) ? true : false;
                        $old->has_private_garden = (isset($input['has_private_garden'])&&$input['has_private_garden']) ? true : false;
                        $old->has_shared_garden = (isset($input['has_shared_garden'])&&$input['has_shared_garden']) ? true : false;
                        $old->has_furnished_garden = (isset($input['has_furnished_garden'])&&$input['has_furnished_garden']) ? true : false;
                        $old->has_parking_space = (isset($input['has_parking_space'])&&$input['has_parking_space']) ? true : false;
                        $old->has_playground = (isset($input['has_playground'])&&$input['has_playground']) ? true : false;
                        $old->has_mountain_sights = (isset($input['has_mountain_sights'])&&$input['has_mountain_sights']) ? true : false;
                        $old->has_sea_sights = (isset($input['has_sea_sights'])&&$input['has_sea_sights']) ? true : false;
                        $old->has_fireplace = (isset($input['has_fireplace'])&&$input['has_fireplace']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_jacuzzi = (isset($input['has_jacuzzi'])&&$input['has_jacuzzi']) ? true : false;
                        $old->has_tv = (isset($input['has_tv'])&&$input['has_tv']) ? true : false;
                        $old->has_cable_tv = (isset($input['has_cable_tv'])&&$input['has_cable_tv']) ? true : false;
                        $old->has_internet = (isset($input['has_internet'])&&$input['has_internet']) ? true : false;
                        $old->has_heating = (isset($input['has_heating'])&&$input['has_heating']) ? true : false;
                        $old->has_fan = (isset($input['has_fan'])&&$input['has_fan']) ? true : false;
                        $old->has_cradle = (isset($input['has_cradle'])&&$input['has_cradle']) ? true : false;
                        $old->has_hairdryer = (isset($input['has_hairdryer'])&&$input['has_hairdryer']) ? true : false;
                        $old->has_dishwasher = (isset($input['has_dishwasher'])&&$input['has_dishwasher']) ? true : false;
                        $old->has_fridge = (isset($input['has_fridge'])&&$input['has_fridge']) ? true : false;
                        $old->has_oven = (isset($input['has_oven'])&&$input['has_oven']) ? true : false;
                        $old->has_microwave = (isset($input['has_microwave'])&&$input['has_microwave']) ? true : false;
                        $old->has_coffee_maker = (isset($input['has_coffee_maker'])&&$input['has_coffee_maker']) ? true : false;
                        $old->has_dryer = (isset($input['has_dryer'])&&$input['has_dryer']) ? true : false;
                        $old->has_washer = (isset($input['has_washer'])&&$input['has_washer']) ? true : false;
                        $old->has_iron = (isset($input['has_iron'])&&$input['has_iron']) ? true : false;
                        $old->is_smoking_allowed = (isset($input['is_smoking_allowed'])&&$input['is_smoking_allowed']) ? true : false;
                        $old->is_pet_allowed = (isset($input['is_pet_allowed'])&&$input['is_pet_allowed']) ? true : false;
                        $old->has_elevator = (isset($input['has_elevator'])&&$input['has_elevator']) ? true : false;
                        $old->is_car_recommended = (isset($input['is_car_recommended'])&&$input['is_car_recommended']) ? true : false;
                        $old->is_handicapped_adapted = (isset($input['is_handicapped_adapter'])&&$input['is_handicapped_adapter']) ? true : false;
                        $old->is_out_town_center = (isset($input['is_out_town_center'])&&$input['is_out_town_center']) ? true : false;
                        $old->is_isolated = (isset($input['is_isolated'])&&$input['is_isolated']) ? true : false;
                        $old->is_nudist_area = (isset($input['is_nudist_area'])&&$input['is_nudist_area']) ? true : false;
                        $old->is_bar_area = (isset($input['is_bar_area'])&&$input['is_bar_area']) ? true : false;
                        $old->is_gayfriendly_area = (isset($input['is_gayfriendly_area'])&&$input['is_gayfriendly_area']) ? true : false;
                        $old->is_family_tourism_area = (isset($input['is_family_tourism_area'])&&$input['is_family_tourism_area']) ? true : false;
                        $old->is_luxury_area = (isset($input['is_luxury_area'])&&$input['is_luxury_area']) ? true : false;
                        $old->is_charming = (isset($input['is_charming'])&&$input['is_charming']) ? true : false;
                        $old->has_bicycle_rental = (isset($input['has_bicycle_rental'])&&$input['has_bicycle_rental']) ? true : false;
                        $old->has_car_rental = (isset($input['has_car_rental'])&&$input['has_car_rental']) ? true : false;
                        $old->has_adventure_activities = (isset($input['has_adventure_activities'])&&$input['has_adventure_activities']) ? true : false;
                        $old->has_kindergarten = (isset($input['has_kindergarten'])&&$input['has_kindergarten']) ? true : false;
                        $old->has_sauna = (isset($input['has_sauna'])&&$input['has_sauna']) ? true : false;
                        $old->has_tennis_court = (isset($input['has_tennis_court'])&&$input['has_tennis_court']) ? true : false;
                        $old->has_paddle_court = (isset($input['has_paddle_court'])&&$input['has_paddle_court']) ? true : false;
                        $old->has_gym = (isset($input['has_gym'])&&$input['has_gym']) ? true : false;
                        $old->description = $input['description'];

                        //delete old prices
                        $old->prices()->delete();

                        //associate new prices with old lodging
                        foreach($input as $key => $value) {
                            $exp_key = explode('-', $key);
                            if($exp_key[0] == 'n_season') {
                                SeasonPrice::create([
                                    'n_season'                  => $value,
                                    'from_date'                 => Carbon::createFromFormat('d/m/Y',$input['from_date-'.$value]),
                                    'to_date'                   => Carbon::createFromFormat('d/m/Y',$input['to_date-'.$value]),
                                    'p_one_night'               => $input['p_one_night-'.$value],
                                    'p_weekend_night'           => $input['p_weekend_night-'.$value],
                                    'p_one_week'                => $input['p_one_week-'.$value],
                                    'p_half_month'              => $input['p_half_month-'.$value],
                                    'p_one_month'               => $input['p_one_month-'.$value],
                                    'p_extra_guest_per_night'   => $input['p_extra_guest_per_night-'.$value],
                                    'n_min_nights'              => $input['n_min_nights-'.$value],
                                    'rent_vacation_id'          => $old->id
                                ]);
                            }
                        }
                        break;
                    case '8': //room
                        $old = Room::findOrFail($input['local_id']);
                        $old->price = $input['price'];
                        $old->deposit = $input['deposit'];
                        $old->lat = $input['lat'];
                        $old->lng = $input['lng'];
                        $old->formatted_address = $input['formatted_address'];
                        $old->street_number = $input['street_number'];
                        $old->route = $input['route'];
                        $old->locality = $input['locality'];
                        $old->admin_area_lvl2 = $input['admin_area_lvl2'];
                        $old->admin_area_lvl1 = $input['admin_area_lvl1'];
                        $old->country = $input['country'];
                        $old->postal_code = $input['postal_code'];
                        $old->hide_address = (isset($input['hide_address'])&&$input['hide_address']) ? true : false;
                        $old->floor_number = $input['floor_number'];
                        $old->is_last_floor = (isset($input['is_last_floor'])&&$input['is_last_floor']) ? true : false;
                        $old->door = $input['door'];
                        $old->has_block = (isset($input['has_block'])&&$input['has_block']) ? true : false;
                        $old->block = (isset($input['has_block'])&&$input['has_block']&&isset($input['block'])) ? $input['block'] : null;
                        $old->residential_area = $input['residential_area'];
                        $old->category_room_id = $input['category_room_id'];
                        $old->area_room = $input['area_room'];
                        $old->n_people = $input['n_people'];
                        $old->n_bedrooms = $input['n_bedrooms'];
                        $old->n_bathrooms = $input['n_bathrooms'];
                        $old->current_tenants_gender_id = $input['current_tenants_gender_id'];
                        $old->is_smoking_allowed = (isset($input['is_smoking_allowed'])&&$input['is_smoking_allowed']) ? true : false;
                        $old->is_pet_allowed = (isset($input['is_pet_allowed'])&&$input['is_pet_allowed']) ? true : false;
                        $old->min_current_tenants_age = $input['min_current_tenants_age'];
                        $old->max_current_tenants_age = $input['max_current_tenants_age'];
                        $old->has_elevator = (isset($input['has_elevator'])&&$input['has_elevator']) ? true : false;
                        $old->has_furniture = (isset($input['has_furniture'])&&$input['has_furniture']) ? true : false;
                        $old->has_builtin_closets = (isset($input['has_builtin_closets'])&&$input['has_builtin_closets']) ? true : false;
                        $old->has_air_conditioning = (isset($input['has_air_conditioning'])&&$input['has_air_conditioning']) ? true : false;
                        $old->has_internet = (isset($input['has_internet'])&&$input['has_internet']) ? true : false;
                        $old->has_house_keeper = (isset($input['has_house_keeper'])&&$input['has_house_keeper']) ? true : false;
                        $old->tenant_gender_id = $input['tenant_gender_id'];
                        $old->tenant_occupation_id = $input['tenant_occupation_id'];
                        $old->tenant_sexual_orientation_id = $input['tenant_sexual_orientation_id'];
                        $old->tenant_min_stay_id = $input['tenant_min_stay_id'];
                        $old->description = $input['description'];
                        break;
                }
                break;
        }

        //return success to admin dashboard
        if(isset($old)&&$old->save()) {
            $Ad->touch();
            return redirect('dashboard')
                ->with('success',['Stitle'=>'Editar anuncio','Smsg'=>'Los datos del anuncio han sido actualizados satisfactoriamente.']);
        }
        return redirect('dashboard')
            ->with('error', ['Etitle'=>'Editar anuncio', 'Emsg'=>'Se produjo un error al tratar de actualizar los datos del anuncio. Si el problema persiste póngase en contacto con el servicio técnico de la aplicación.']);
    }

    public function uploadImage()
    {
        $files = \Input::file('files');
        list($usec, $sec) = explode(" ", microtime());
        $timeStamp = $sec . substr($usec,2,(strlen($usec)-4)); //get Unix time in microsecons as a string
        $date = new \DateTime();
        $today = $date->format('d/m/Y');
        $thumbsPath = public_path() . '/ads/thumbnails/';
        $picsPath = public_path() . '/ads/pictures/';

        foreach ($files as $f) { // There will be only one $f (plugin sends one POST per image)
            // Validation (it is an image)
            $validImg = \Validator::make(['file' => $f], ['file' => 'image']);
            if ($validImg->fails())
                return \Response::json('error', 400);

            // Move uploaded image to destination path (original size/resolution is kept)
            $filename = $timeStamp . '_' . $f->getClientOriginalName();
            $f->move($picsPath, $filename);

            // Create a thumbnail for the image
            $img = \Image::make($picsPath . $filename);
            $img->fit(300,225)->save($thumbsPath . "thumb_" . $filename);

            // Prepare JSON output
            list($width, $height) = getimagesize('ads/pictures/' . $filename);
            $filesize = (int) (filesize('ads/pictures/' . $filename) * 0.001);
            return \Response::json([
                'files'=> [
                    '0'=>[
                        "name"          => $filename,
                        "size"          => $filesize,
                        "thumbnail"     => "thumb_" . $filename,
                        "width"         => $width,
                        "height"        => $height,
                        "created_at"    => $today
                    ]
                ]
            ], 200);
        }
        return \Response::json('error', 400);
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function config()
    {
        $options = Constants::first();
        return view('config', compact('options'));
    }

    public function updateDevOptions()
    {
        $input = \Input::all();

        $options = Constants::first();
        $options->n_ad_seeds = $input['n_ad_seeds'];
        $options->starting_year = $input['starting_year'];
        $options->dev_version = $input['dev_version'];
        $options->dev_email = $input['dev_email'];

        if($options->save())
            return \Response::json('success',200);
        return \Response::json('error',400);
    }

    public function updateWebImages()
    {
        $options = Constants::first();
        if(\Input::hasFile('public_logo')) {
            list($usec, $sec) = explode(" ", microtime());
            $timeStamp = $sec . substr($usec,2,(strlen($usec)-4)); //get Unix time in microseconds as a string
            $file = \Input::file('public_logo');
            $filename = $timeStamp .'_'. \Input::file('public_logo')->getClientOriginalName();
            $path = public_path().'/img/logos/';
            $file->move($path, $filename);
            list($width, $height) = getimagesize('img/logos/' . $filename);
            $options->public_logo = $filename;
            $options->pl_height = $height;
            $options->pl_width = $width;
        }
        if(\Input::hasFile('dashboard_logo')) {
            list($usec, $sec) = explode(" ", microtime());
            $timeStamp = $sec . substr($usec,2,(strlen($usec)-4));
            $file = \Input::file('dashboard_logo');
            $filename = $timeStamp .'_'. \Input::file('dashboard_logo')->getClientOriginalName();
            $path = public_path().'/img/logos/';
            $file->move($path, $filename);
            list($width, $height) = getimagesize('img/logos/' . $filename);
            $options->dashboard_logo = $filename;
            $options->dl_height = $height;
            $options->dl_width = $width;
        }

        if($options->save())
            return \Response::json('success',200);
        return \Response::json('error',400);
    }

    public function updateWebInfo()
    {
        $input = \Input::all();

        $options = Constants::first();
        $options->company_name = $input['company_name'];
        $options->company_description = $input['company_description'];
        $options->company_phone = $input['company_phone'];
        $options->company_email = $input['company_email'];
        $options->lat = $input['lat'];
        $options->lng = $input['lng'];
        $options->formatted_address = $input['formatted_address'];
        $options->street_number = $input['street_number'];
        $options->route = $input['route'];
        $options->locality = $input['locality'];
        $options->admin_area_lvl2 = $input['admin_area_lvl2'];
        $options->admin_area_lvl1 = $input['admin_area_lvl1'];
        $options->country = $input['country'];
        $options->postal_code = $input['postal_code'];

        if($options->save())
            return \Response::json('success',200);
        return \Response::json('error',400);
    }

}