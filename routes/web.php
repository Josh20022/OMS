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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::post('/contact-email', 'App\Http\Controllers\ContactController@contactEmail')->name('contactEmail');
Route::get('/news', 'App\Http\Controllers\NewsController@index')->name('news');
Route::get('/news/{id}', 'App\Http\Controllers\NewsController@show')->name('news.show');

/*language switch*/
Route::get('/lang/switch/{code}', 'App\Http\Controllers\HomeController@switchLang');


Route::group(['middleware' => 'guest'], function() {
    Route::get('/dashboard/login', 'App\Http\Controllers\Dashboard\AuthController@authForm')->name('login.form');
    Route::post('/dashboard/login', 'App\Http\Controllers\Dashboard\AuthController@auth')->name('login');
    Route::get('/login', 'App\Http\Controllers\AuthController@authForm')->name('user.login.form');
    Route::post('/login', 'App\Http\Controllers\AuthController@auth')->name('user.login');
    Route::get('/forgot-password', 'App\Http\Controllers\ForgotPasswordController@forgotPasswordForm')->name('forgot.form');
    Route::post('/forgot-password', 'App\Http\Controllers\ForgotPasswordController@submitForgotPassword')->name('forgot');
    Route::get('/reset-password/{token}', 'App\Http\Controllers\ForgotPasswordController@resetPasswordForm')->name('reset.token');
    Route::post('/reset-password', 'App\Http\Controllers\ForgotPasswordController@resetPassword')->name('reset');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
    Route::get('/media/{userId}/{slug}', 'App\Http\Controllers\MediaController@show')->name('media');
});

Route::domain('{subdomain}.' . getDomain())->group(function () {
    Route::get('/profile', 'App\Http\Controllers\UserController@profile')->middleware('subdomain');
    Route::post('/profile', 'App\Http\Controllers\UserController@update')->middleware('subdomain');
    Route::get('/form/{id}', 'App\Http\Controllers\FormController@index')->middleware('subdomain');
    Route::post('/form/{id}', 'App\Http\Controllers\FormController@submit')->middleware('subdomain');
    Route::get('/page/{id}', 'App\Http\Controllers\PageController@index')->middleware('subdomain');
});

Route::group(['prefix' => 'dashboard'], function() {
    Route::get('/', 'App\Http\Controllers\Dashboard\DashboardController@index')->middleware('client')->name('dashboard');
    Route::get('/settings', 'App\Http\Controllers\Dashboard\SettingController@index')->middleware('admin')->name('settings');
    Route::post('/settings', 'App\Http\Controllers\Dashboard\SettingController@store')->middleware('admin')->name('settings.store');
    Route::get('/texts', 'App\Http\Controllers\Dashboard\TextController@index')->middleware('admin')->name('texts');
    Route::post('/texts', 'App\Http\Controllers\Dashboard\TextController@store')->middleware('admin')->name('texts.store');
    Route::resource('/users', 'App\Http\Controllers\Dashboard\UserController')->middleware('client');
    Route::resource('/clients', 'App\Http\Controllers\Dashboard\ClientController')->middleware('client');
    Route::post('/client/duplicate/{id}', 'App\Http\Controllers\Dashboard\ClientController@duplicate')->middleware('admin')->name('client.duplicate');
    Route::resource('/forms', 'App\Http\Controllers\Dashboard\FormController')->middleware('client');
    Route::resource('/isos', 'App\Http\Controllers\Dashboard\IsoController')->middleware('admin');
    Route::resource('/slides', 'App\Http\Controllers\Dashboard\SlideController')->middleware('admin');
    Route::resource('/methods', 'App\Http\Controllers\Dashboard\MethodController')->middleware('admin');
    Route::resource('/advantages', 'App\Http\Controllers\Dashboard\AdvantageController')->middleware('admin');
    Route::resource('/data', 'App\Http\Controllers\Dashboard\DataController')->middleware('client');
    Route::post('/forms/duplicate/{id}', 'App\Http\Controllers\Dashboard\FormController@duplicate')->middleware('client')->name('form.duplicate');
    Route::get('/forms/data/{id}', 'App\Http\Controllers\Dashboard\FormController@data')->middleware('client')->name('form.data');
    Route::resource('/pages', 'App\Http\Controllers\Dashboard\PageController')->middleware('client');
    Route::post('/pages/file-upload', 'App\Http\Controllers\Dashboard\PageController@fileUpload')->middleware('client');
    Route::post('/pages/duplicate/{id}', 'App\Http\Controllers\Dashboard\PageController@duplicate')->middleware('client')->name('page.duplicate');
    Route::post('/order', 'App\Http\Controllers\Dashboard\OrderController@setOrder')->middleware('client')->name('order');



    /*translations*/
    Route::resource('/languages', 'App\Http\Controllers\Dashboard\LanguageController')->middleware('admin');
    Route::resource('/{code}/translations', 'App\Http\Controllers\Dashboard\TranslationController')->middleware('admin');





});
