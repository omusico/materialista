<?php namespace App\Http\Controllers;

class AdminController extends Controller {

    public function __construct()
    {
        $this->middleware('guest');
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

}