<?php

use App\Http\Controllers\AdminController;

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

//Home page
Route::get('/', 'IndexController@index');

//category wise show products pages
Route::get('/user/products/{url}', 'ProductController@products');

//Brand wise show products pages
Route::get('/user/brand/{url}', 'ProductController@brand');

//product details page
Route::get('/user/details/product/{id}', 'ProductController@product_details');

//Login page
Route::match(['get', 'post'], '/admin_login', 'AdminController@login');

//get product price
Route::get('/get-product-price', 'ProductController@getProductPrice');

//add to Cart page
Route::match(['get', 'post'], '/user/add-cart', 'ProductController@add_cart');

//Cart page display
Route::match(['get', 'post'], '/user/cart', 'ProductController@cart');

//cart item delete
Route::get('/user/cart-delete/{id}', 'ProductController@delete_cart');

//Update cart product quantity
Route::get('/users/cart/update-quantity/{id}/{quantity}', 'ProductController@update_quantity');

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/admin/dashboard', 'AdminController@dashboard');

    Route::get('/admin/setting', 'AdminController@setting');

    Route::get('/admin/check-pwd', 'AdminController@chkPassword');

    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@update_password');

    Route::get('/logout', 'AdminController@logout');

    //Category Route

    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@edit_category');
    Route::get('/admin/view-category', 'CategoryController@view_category');
    Route::get('/admin/delete-category/{id}', 'CategoryController@delete_category');

    //Brand Route

    Route::match(['get', 'post'], '/admin/add-brand', 'BrandController@add_brand');
    Route::match(['get', 'post'], '/admin/edit-brand/{id}', 'BrandController@edit_brand');
    Route::get('/admin/view-brand', 'BrandController@view_brand');
    Route::get('/admin/delete-brand/{id}', 'BrandController@delete_brand');

    //Product Route

    Route::match(['get', 'post'], '/admin/add-product', 'ProductController@add_product');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductController@edit_product');
    Route::get('/admin/view-product', 'ProductController@view_product');
    Route::get('/admin/delete-product/{id}', 'ProductController@delete_product');
    Route::get('/admin/delete-product-image/{id}', 'ProductController@delete_product_image');

    //Product Attributes

    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductController@add_attributes');
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}', 'ProductController@edit_attributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductController@delete_attributes');

    //Add Image attributes
    Route::match(['get', 'post'], '/admin/add-image/{id}', 'ProductController@add_attributes_image');
    Route::get('/admin/delete-image/{id}', 'ProductController@delete_image');

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
