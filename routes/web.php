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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'LandingController@index');

// facebook login
Route::get('auth/{provider}', ['as'=> 'social.login', 'uses'=> 'Auth\RegisterController@redirectToProvider']);
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::resource('/landing/video', 'VideoController', [
  'names'=> [
    'index'  => 'landing.video.index',
    'show'  => 'landing.video.show'
  ]
]);

Route::resource('/landing/puzzle', 'PuzzleController', [
  'names'=> [
    'show'  => 'landing.puzzle.show'
  ]
]);

Route::get('/puzzle/{id}', ['as'=>'puzzle', 'uses'=>'LandingController@puzzle']);

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
  Route::post('admin/assets/bulk_action', ['as'=>'admin.assets.bulk_action', 'uses'=>'admin\AdminAssetController@bulk_action']);
  Route::post('admin/assets/changeprofileimg', ['as'=>'admin.assets.changeprofileimg', 'uses'=>'admin\AdminAssetController@changeprofileimg']);
  Route::post('admin/puzzles/completepuzzle', ['as'=>'admin.puzzles.completepuzzle', 'uses'=>'admin\AdminPuzzleController@completepuzzle']);

  // delete uploaded asset when upload done
  Route::get('admin/assets/removeuploadedasset/{id}', ['as'=>'admin.assets.removeuploadedasset', 'uses'=>'admin\AdminAssetController@removeuploadedasset']);


  Route::resource('/admin/assets', 'admin\AdminAssetController', [
    'names'=> [
      'index'  => 'admin.assets.index',
      'create'  => 'admin.assets.create',
      'show'  => 'admin.assets.show',
      'edit'  => 'admin.assets.edit',
      'update'  => 'admin.assets.update',
      'store'  => 'admin.assets.store'
    ]
  ]);

  Route::resource('/admin/users', 'admin\AdminUsersController', [
    'names'=> [
      'index'  => 'admin.users.index',
      'create'  => 'admin.users.create',
      'edit'  => 'admin.users.edit',
      'store'  => 'admin.users.store',
      'update'  => 'admin.users.update'
    ]
  ]);

  Route::resource('/admin/puzzles', 'admin\AdminPuzzleController', [
    'names'=> [
      'index'  => 'admin.puzzles.index',
      'show'  => 'admin.puzzles.show'
    ]
  ]);


});

Route::group(['middleware'=>'user'], function(){
  Route::resource('/user/', 'user\UserDashboardController', [
    'names'=> [
      'index'  => 'user.index'
    ]
  ]);

  Route::post('user/assets/store_asset', ['as'=>'user.assets.store_asset', 'uses'=>'user\UserAssetController@store_asset']);
  Route::post('user/assets/update_asset', ['as'=>'user.assets.update_asset', 'uses'=>'user\UserAssetController@update_asset']);
  Route::post('user/assets/bulk_action', ['as'=>'user.assets.bulk_action', 'uses'=>'user\UserAssetController@bulk_action']);
  Route::post('user/assets/changeprofileimg', ['as'=>'user.assets.changeprofileimg', 'uses'=>'user\UserAssetController@changeprofileimg']);

  // delete uploaded asset when upload done
  Route::get('user/assets/removeuploadedasset/{id}', ['as'=>'user.assets.removeuploadedasset', 'uses'=>'user\UserAssetController@removeuploadedasset']);


  Route::resource('/user/assets', 'user\UserAssetController', [
    'names'=> [
      'index'  => 'user.assets.index',
      'create'  => 'user.assets.create',
      'show'  => 'user.assets.show',
      'edit'  => 'user.assets.edit',
      'update'  => 'user.assets.update',
      'store'  => 'user.assets.store'
    ]
  ]);

  Route::resource('/user/users', 'user\UserUsersController', [
    'names'=> [
      'index'  => 'user.users.index',
      'create'  => 'user.users.create',
      'edit'  => 'user.users.edit',
      'store'  => 'user.users.store',
      'update'  => 'user.users.update'
    ]
  ]);

  Route::post('user/puzzles/completepuzzle', ['as'=>'user.puzzles.completepuzzle', 'uses'=>'user\UserPuzzleController@completepuzzle']);

  Route::resource('/user/puzzles', 'user\UserPuzzleController', [
    'names'=> [
      'index'  => 'user.puzzles.index',
      'show'  => 'user.puzzles.show'
    ]
  ]);
});
