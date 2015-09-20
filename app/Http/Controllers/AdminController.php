<?php namespace App\Http\Controllers;

use App\Ad;
use App\AdPic;
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
        if(isset($new)&&isset($newTable)) {
            $newAd->local_table = $table;
            $newAd->local_id = $new->id;
            $newAd->save();
        }

        //todo: return success to admin dashboard
        if(isset($new))
            exit($new->toJson());
        exit('Did not do');
    }

    public function uploadImage()
    {
        $files = \Input::file('files');
        list($usec, $sec) = explode(" ", microtime());
        $timeStamp = $sec . substr($usec,2,(strlen($usec)-4)); //get Unix time in microsecons, as a string
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

}