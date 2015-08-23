<?php namespace App\Http\Controllers;

class AdminController extends Controller {

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showNewAdForm() {
        $input = \Input::all();
        $operation = (isset($input['operation'])) ? $input['operation'] : '0';
        $typology = (isset($input['typology'])) ? $input['typology'] : '0';
        if($typology=='7'||$typology=='8')
            $operation = '1';

        return view('new_ad_form', compact('operation','typology'));
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
        return \Response::json(['done'=>'done'],200);
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

}