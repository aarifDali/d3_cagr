<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' =>'admin','namespace' => 'Admin', 'as'=>'admin.', 'middleware' => ['auth']], function(){  
	Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
	Route::resource('user','UserController');
	Route::get('user/load_data', 'UserController@loadData')->name('user.load_data');
	Route::get('user/profile-view/{id}/', 'UserController@profileView')->name('user.profile_view');

});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => ['auth']], function(){
	Route::resource('category','CategoryController');
	Route::get('category/category-view/{id}/', 'CategoryController@categoryView')->name('category.category_view');

});

Route::group(['prefix' => 'ajax'], function () {
	Route::post('status', 'AjaxController@status')->name('ajax.status');
	Route::post('type', 'AjaxController@type')->name('ajax.type');
    Route::post('check_existence', 'AjaxController@checkExistence')->name('ajax.check_existence');
});
 
require __DIR__.'/auth.php'; 
