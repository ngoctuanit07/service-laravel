<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth', 'role:admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();
Route::resource('testxml', 'TestController');
// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::post('admin/dongbo/{id}', 'CrawController@dongbo')->name('admin.dongbo');
    Route::post('admin/sync/{id}', 'CrawCatController@sync')->name('admin.sync');
    Route::post('admin/import/{id}', 'ConfigController@import')->name('admin.import');
    Route::resource('admin/users', 'UserController');
    Route::resource('admin/roles', 'RoleController');
    Route::resource('admin/craw', 'CrawController');
    Route::resource('admin/proxy', 'ProxyController');
    Route::resource('admin/tracking', 'TrackingKeywordController');
    Route::resource('admin/configtracking', 'ConfigTrackingKeywordController');
    Route::resource('admin/crawcat', 'CrawCatController');
    Route::resource('admin/config', 'ConfigController');
    Route::get('admin/importCat', 'CrawCatController@importCat')->name('admin.importCat');
    Route::resource('admin/permission', 'PermissionController');
    Route::resource('admin/document', 'DocumentController');

    // Route::resource('admin/profile','ProfileController');
    // Route::get('admin/document','DocumentController@index')->name('admin.document');
    Route::get('admin/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    // Route::get('admin/document','Admin\DocumentController@index')->name('admin.document');
});
Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::post('admin/dongbo/{id}', 'CrawController@dongbo')->name('admin.dongbo');
    Route::resource('admin/craw', 'CrawController');
    Route::resource('admin/document', 'DocumentController');
    Route::resource('admin/profile', 'ProfileController');
    Route::get('admin/home', 'DashboardController@index')->name('home.dashboard');
    Route::post('admin/sync/{id}', 'CrawCatController@sync')->name('admin.sync');
    Route::post('admin/import/{id}', 'ConfigController@import')->name('admin.import');
    Route::resource('admin/crawcat', 'CrawCatController');
    Route::resource('admin/config', 'ConfigController');
    Route::resource('admin/tracking', 'TrackingKeywordController');
    Route::resource('admin/configtracking', 'ConfigTrackingKeywordController');
    // Route::get('admin/document','DocumentController@index')->name('admin.document');
});
Route::get('fee-ghtk', "GHTKControler@fee");
