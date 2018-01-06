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

Route::get('/', function () {
    //throw new\Exception('Tracyworks!');
    return view('welcome');
})->middleware(checkage::class);

Route::get('/home', function () {

    return view('welcome');
})->name("home");

Route::get('mail', 'MailController@getSend');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'login/social','middleware'=>['guest']],
    function(){
    Route::get('{provider}/redirect',[
        'as' => 'social.redirect',
        'uses' => 'SocialController@getSocialRedirect'   ]);
    Route::get('{provider}/callback',[
        'as' => 'social.handle',
        'uses' => 'SocialController@getSocialCallback'
    ]);
});
