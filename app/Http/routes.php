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

// Authentication
Route::get('acceso', ['as'=>'auth.login','uses'=>'Auth\AuthController@getLogin']);
Route::post('auth/login', ['as'=>'auth.doLogin','uses'=>'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as'=>'auth.logout','uses'=>'Auth\AuthController@getLogout']);

// Registration
Route::get('auth/register', ['as'=>'auth.register','uses'=>'Auth\AuthController@getRegister']);
Route::post('auth/register', ['as'=>'auth.doRegister','uses'=>'Auth\AuthController@postRegister']);

//Reset password
Route::get('auth/reset', ['as'=>'auth.reset','uses'=>'AuthController@reset']);
Route::post('auth/reset', ['as'=>'auth.doReset','uses'=>'AuthController@doreset']);

//Home & Main search
Route::get('/', ['as'=>'home','uses'=>'HomeController@index']);
Route::post('updateAdminsAndLocalities', ['as'=>'update.list.1','uses'=>'HomeController@postAdminsAndLocalities']);
Route::post('updateLocalities', ['as'=>'update.list.2','uses'=>'HomeController@postLocalities']);

//Results page
Route::get('/resultados', ['as'=>'results','uses'=>'HomeController@getResults']);

//Ad page
Route::get('/anuncio/{id}', ['as'=>'ad.profile','uses'=>'HomeController@adProfile']);
Route::post('/sendContactForm', ['as'=>'send.contact.form','uses'=>'HomeController@sendContactForm']);

//Admin dashboard
Route::get('/dashboard', ['as'=>'dashboard.home','uses'=>'AdminController@dashboard']);

//Create and edit ad form
Route::get('dashboard/newAd', ['as'=>'dashboard.newAd','uses'=>'AdminController@getNewAd']);
Route::get('dashboard/editAd', ['as'=>'dashboard.editAd','uses'=>'AdminController@getAdsList']);
Route::get('check_address', 'AdminController@checkAddress');
Route::post('new_ad', ['as'=>'new.ad','uses'=>'AdminController@doNewAd']);
Route::post('edit_ad', ['as'=>'edit.ad','uses'=>'AdminController@doEditAd']);
Route::post('upload_img',['as'=>'upload.img','uses'=>'AdminController@uploadImage']);
Route::get('dashboard/editAd/{ad_id}', ['as'=>'dashboard.editAd.id','uses'=>'AdminController@editAd']);
Route::get('dashboard/config', ['as'=>'dashboard.config','uses'=>'AdminController@config']);
Route::post('update/dev-options', ['as'=>'update.dev.options','uses'=>'AdminController@updateDevOptions']);
Route::post('update/web-images', ['as'=>'update.web.images','uses'=>'AdminController@updateWebImages']);
Route::post('update/web-info', ['as'=>'update.web.info','uses'=>'AdminController@updateWebInfo']);
Route::post('update/search-options', ['as'=>'update.search.options','uses'=>'AdminController@updateSearchOptions']);

//Development: view tables
Route::get('table/{table_name}', ['as'=>'view.table','uses'=>'DeveloperController@showTable']);
