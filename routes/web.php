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
use App\User;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// logout function
Route::get('/logout', 'Auth\LoginController@logout');

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware'=>'admin'], function(){
  Route::resource('/admin/', 'admin\AdminDashboardController', [
    'names'=> [
      'index'  => 'admin.index'
    ]
  ]);


  Route::post('admin/assets/store_asset', ['as'=>'admin.assets.store_asset', 'uses'=>'admin\AdminAssetController@store_asset']);
  Route::post('admin/assets/update_asset', ['as'=>'admin.assets.update_asset', 'uses'=>'admin\AdminAssetController@update_asset']);

  Route::resource('/admin/assets', 'admin\AdminAssetController', [
    'names'=> [
      'index'  => 'admin.assets.index',
      'create'  => 'admin.assets.create',
      'show'  => 'admin.assets.show',
      'store'  => 'admin.assets.store'
    ]
  ]);


});

Route::group(['middleware'=>'user'], function(){
  Route::resource('/user/', 'user\UserDashboardController', [
    'names'=> [
      'index'  => 'user.index'
    ]
  ]);
});
