<?php
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// this middleware for backend authenticated users
Route::group(['middleware' => ['auth']], function () {
    // Dashboard landing page
    Route::get('/backend/dashboard', 'BackendHomeController@index');
    //Articles Routes
    Route::resource('/backend/articles', 'ArticlesController');
    //Toggle Active
    Route::post('/common/toggle_active', 'CommonController@toggleActive');
});

// this middleware is just for admin
Route::group(['middleware' => ['admin']], function () {
    //Admins Roots
    Route::resource('/backend/admins', 'AdminsController');
    //Change Password for Admin
    Route::post('/backend/admins/change_password', 'AdminsController@changePassword');
});

Route::get('/test', 'TestController@index');

Route::get('/backend', function () {
    if(Auth::user())
        return Redirect::to('/backend/dashboard');
    else
        return Redirect::to('login');
});

// logout route
Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('login');
});

