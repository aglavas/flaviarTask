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

Route::group(['middleware' => ['guest']], function () {

    Route::view('/', 'auth.login')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('post.login');

});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::view('/admin/home', 'admin.home')->name('admin.home');

    //Products
    Route::get('/admin/products', 'Admin\ProductController@getProducts')->name('get.products');
    Route::post('/admin/products', 'Admin\ProductController@postProducts')->name('post.product');


});
