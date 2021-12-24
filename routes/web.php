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
#TODO REF: https://laraveldaily.com/how-to-structure-routes-in-large-laravel-projects/
/* Route::get('/', function () {
     return view('welcome');
 });*/
#Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
/** front-end routes */


Route::get('/', 'HomeController@index');
Route::get('/', 'HomeController@index')->name('/');
Route::get('sso/{token?}', 'HomeController@sso')->name('sso');
Route::get('menu/{slug}', 'MenuController@menu')->name('menu');
Route::get("logout", "HomeController@logout")->name("logout");
Route::group(['middleware' => ['auth', 'prevent-back-history']], function() {
    Route::get('custom-menu/{type?}', 'Front\CustomMenuController@manageCustomMenu')->name('custom-menu');
    #Route::get('my-profile', 'Front\UserController@myProfile')->name('my-profile');
    #Route::get('dashboard', 'Front\UserController@dashboard')->name('dashboard');
});
//Front Folder and Front NameSpaces Controller
/*Route::group([
    'name' => 'front.',
    'prefix' => '', //front
    'namespace' => 'Front',
], function () {
    Route::get('about-us', 'AboutController@index')->name('about');
    //Route::get('contact', 'ContactController@index')->name('contact');
    Route::get('custom-menu/{type?}', 'CustomMenuController@manageCustomMenu')->name('custom-menu');

//    Route::group([
//        'name' => 'user.',
//        'prefix' => 'user',
//    ], function () {
//
//        // URL: /user/profile
//        // Route name: user.profile
//        Route::get('profile', 'ProfileController@index')->name('profile');
//
//    });
});*/

/*Route::get('test-code', 'Front\CartController@test_code')->name('test-code');
Route::get('/', 'HomeController@index')->name('home');
Route::get('privacy-policy', 'HomeController@privacyPolicy')->name('privacy-policy');
Route::get('terms', 'HomeController@terms')->name('terms');
Route::get('about', 'HomeController@about')->name('about');
Route::get('why-us', 'HomeController@why_us')->name('why-us');
Route::get('sign-faqs', 'HomeController@sign_faqs')->name('sign-faqs');
Route::get('mission-statement', 'HomeController@mission_statement')->name('mission-statement');
Route::get('testimonial', 'HomeController@testimonial')->name('testimonial');
Route::get('environment', 'HomeController@environment')->name('environment');*/

/** front-end routes */

