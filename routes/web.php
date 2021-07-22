<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('landingpage');
// });

// Route::get('/traveller', function () {
//     return view('traveller.home');
// });

// Route::get('/login/login', function () {
//     return view('login.login');
// });

// Route::get('/login/daftar', function () {
//     return view('login.daftar');
// });

//routing pages
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');



Route::group(['middleware' => ['auth', 'checkRole:traveller']], function () {
	// Route::get('/home', 'TravellersController@index')->name('home');
	//home
	Route::get('/home', 'TripsController@index')->name('home');

	//travellerscontroller
	Route::get('/myaccount/{traveller}', 'TravellersController@show');
	Route::get('/chat/me/{id_traveller}', 'TravellersController@getWhatsapp');
	Route::get('/myaccount/{traveller}/editprofile', 'TravellersController@edit');
	Route::patch('/myaccount/{traveller}', 'TravellersController@update');
	Route::get('/trip/{traveller}/detail', 'TravellersController@details');

	//trips
	Route::post('/home/createTrip', 'TripsController@store');
	Route::get('/trips/{trip}/edit', 'TripsController@edit');
	Route::patch('/trips/{trip}/update', 'TripsController@update');
	Route::delete('/trips/{trip}/delete', 'TripsController@destroy');

	//search
	Route::any('/home/search', 'TripsController@search')->name('search');

	//filters
	Route::any('/categories/category', 'FiltersController@category')->name('search.people');

	//messages
	Route::post('/message/send/{user_id}', 'MessageController@create');
	Route::post('messages', 'MessageController@sendMessage')->name('send');
	Route::get('/messages', 'MessageController@index')->name('homem');
	Route::get('/messages/{id}', 'MessageController@getMessage')->name('message');
});

//auth
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');
Route::get('/register', 'PagesController@register');
Route::post('/register', 'AuthController@register');