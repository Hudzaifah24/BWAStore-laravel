<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('home');

Route::get('categories', 'CategoryController@index')->name('categories');

Route::get('categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('details/{id}', 'DetailController@index')->name('detail');

Route::post('details/{id}', 'DetailController@add')->name('detail-add');

Route::get('cart', 'CartController@index')->name('cart');

Route::get('cart/success', function(){
    return view('pages.success');
})->name('cart-success');


Route::post('checkout', 'CheckController@process')->name('checkout');
Route::get('checkout/callback', 'CheckController@callback')->name('midtrans-callback');


Route::delete('cart/{id}', 'CartController@delete')->name('cart-delete');

Route::get('register/success', 'Auth\RegisterController@success')->name('success');

Route::get('register', 'Auth\RegisterController@register')->name('register-success');

Route::prefix('dashboard')->group( function(){

    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/product', 'DashboardProductController@index')->name('dashboard-product');

    Route::get('/product/create', 'DashboardProductController@create')->name('dashboard-product-create');

    Route::post('/product', 'DashboardProductController@store')->name('dashboard-product-store');


    Route::get('/product/detail/{id}', 'DashboardProductController@detail')->name('dashboard-product-detail');

    Route::post('/product/update/{id}', 'DashboardProductController@update')->name('dashboard-product-update');

    Route::post('/product/gallery/upload', 'DashboardProductController@uploadGallery')->name('dashboard-product-gallery-upload');

    Route::get('/product/gallery/delete/{id}', 'DashboardProductController@deleteGallery')->name('dashboard-product-gallery-delete');


    Route::get('/Transactions', 'DashboardTransactionsController@index')->name('dashboard-transaction');

    Route::get('/Transactions/detail/{id}', 'DashboardTransactionsController@detail')->name('dashboard-transaction-detail');

    Route::post('/Transactions/update/{id}', 'DashboardTransactionsController@update')->name('dashboard-transaction-update');


    Route::get('/settings', 'DashboardSettingController@store')->name('dashboard-settings-store');

    Route::get('/account', 'DashboardSettingController@account')->name('dashboard-settings-account');

    Route::post('/account/{redirect}', 'DashboardSettingController@update')->name('dashboard-settings-redirect');

});

Route::prefix('admin')
    ->namespace('Admin')
    // ->middleware(['auth', 'admin'])
    ->group(function(){
        Route::get('/dashboard', 'DashboardController@index')->name('admin-dashboard');
        Route::resource('category', 'CategoryController');
        Route::resource('user', 'UserController');
        Route::resource('product', 'ProductController');
        Route::resource('product-gallery', 'ProductGalleryController');
    });

Auth::routes();
