<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@showTesterIndex');

//Home & Main search
Route::get('/home', ['as'=>'home','uses'=>'HomeController@index']);
Route::post('updateAdminsAndLocalities', ['as'=>'update.list.1','uses'=>'HomeController@postAdminsAndLocalities']);
Route::post('updateLocalities', ['as'=>'update.list.2','uses'=>'HomeController@postLocalities']);

//Results page
Route::get('/resultados', ['as'=>'results','uses'=>'HomeController@getResults']);

//New ad form
Route::get('form_new', ['as'=>'form.new.ad','uses'=>'AdminController@showNewAdForm']);
Route::get('check_address', 'AdminController@checkAddress');
Route::post('new_ad', ['as'=>'new.ad','uses'=>'AdminController@doNewAd']);
Route::post('upload_img',['as'=>'upload.img','uses'=>'AdminController@uploadImage']);

//Development: view tables
Route::get('table/{table_name}', ['as'=>'view.table','uses'=>'DeveloperController@showTable']);