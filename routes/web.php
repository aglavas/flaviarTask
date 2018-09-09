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

    Route::view('/', 'auth.login')
        ->name('login');

    Route::post('/login', 'Auth\LoginController@login')
        ->name('post.login');

});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')
        ->name('logout');

    Route::view('/admin/home', 'admin.home')
        ->name('admin.home');

    //Products
    Route::get('/admin/products', 'Admin\ProductController@getProducts')
        ->name('get.products');

    Route::post('/admin/products', 'Admin\ProductController@postProducts')
        ->name('post.product');

    Route::patch('/admin/products/{product}', 'Admin\ProductController@patchProduct')
        ->name('patch.products');

    Route::get('/admin/product/{product}/vendors', 'Admin\ProductController@getProductVendors')
        ->name('get.product.vendors');

    Route::post('/admin/product/{product}/vendors', 'Admin\ProductController@postProductVendors')
        ->name('post.product.vendors');

    Route::get('/admin/product/details', 'Admin\ProductController@getProductDetails')->name('get.details');

    //Vendors
    Route::get('/admin/vendors', 'Admin\VendorController@getVendors')
        ->name('get.vendors');

    Route::patch('/admin/vendors/{vendor}', 'Admin\VendorController@patchVendor')
        ->name('patch.vendors');
});
