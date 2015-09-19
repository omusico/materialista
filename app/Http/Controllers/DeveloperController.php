<?php namespace App\Http\Controllers;

class DeveloperController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTable($table_name) {
        $columns = \Schema::getColumnListing($table_name);
        $rows = \DB::table($table_name)->get();

        return view('print_table', compact('columns','rows'));
    }

}