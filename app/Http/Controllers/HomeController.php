<?php namespace App\Http\Controllers;

use App\HomeLib;
use App\SellHouse;

class HomeController extends Controller {

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showTesterIndex() {
        return view('tester_index');
    }

    public function index() {
        return view('home_search');
    }

    public function postAdminsAndLocalities(){
        $input = \Input::all();
        $response = [];
        $response['admins'] = HomeLib::getAdminLvl2List($input['operation'],$input['typology']);
        $response['localities'] = HomeLib::getLocalityList($input['operation'],$input['typology'],$input['adminLvl2']);

        return \Response::json($response,200);
    }

    public function postLocalities(){
        $input = \Input::all();
        $response = [];
        $response['localities'] = HomeLib::getLocalityList($input['operation'],$input['typology'],$input['adminLvl2']);

        return \Response::json($response,200);
    }

}