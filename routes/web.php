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

//color wise show product
Route::match(['get','post'],'/products/filters','ProductController@filter');

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

//Apply Coupon COde
Route::post('/users/cart/apply-coupon', 'ProductController@apply_coupons');

//user login and regsiter show
Route::get('/user/login-register', 'UsersController@user_login');

//user forget password
Route::match(['get','post'],'/user/forget-password','UsersController@user_forget_password');

//user register
Route::post('/user/user-register', 'UsersController@register');

//confirm account activate
Route::get('confirm/{code}','UsersController@confirmAccount');

//user logout
Route::get('/user/user-logout', 'UsersController@logout');

//user login
Route::post('/user/user-login', 'UsersController@login');

//search products
Route::post('/user/search-product','ProductController@search_products');

//check pincode
Route::post('/check_pincode', 'ProductController@checkPincode');

//check News Letter Subscriber
Route::post('/check-subscriber-email','NewsLetterSubscriberController@checkSubscribe');

//add news letter subscriber
Route::post('/add-subscriber-email','NewsLetterSubscriberController@addSubscribe');

Route::group(['middleware' => ['userLogin']], function () {
    //user account page
    Route::match(['get', 'post'], '/user/user-account', 'UsersController@account');
    //check user password
    Route::post('/user/user-check-pwd', 'UsersController@ChkUserPassword');
    //update password
    Route::post('/user/user-update-password', 'UsersController@updatePassword');
    //checkout page
    Route::match(['get', 'post'], '/user/checkout', 'ProductController@checkout');
    //Order review page
    Route::match(['get', 'post'], '/user/order-review', 'ProductController@orderReview');
    //Place Order
    Route::match(['get', 'post'], '/user/place-order', 'ProductController@placeOrder');
    //Thanks page
    Route::get('/user/thanks', 'ProductController@thanks');
    //Paypal page
    Route::get('/order/paypal', 'ProductController@paypal');
    //User orders Page
    Route::get('/user/orders', 'ProductController@userOrders');
    //User orders Details Page
    Route::get('/user/orderDetails/{id}', 'ProductController@OrdersDetails');
    //paypal thanks page
    Route::get('/order/paypal/thanks', 'ProductController@thanksPaypal');
    //paypal cancel page
    Route::get('/order/paypal/cancel', 'ProductController@cancelPaypal');
    //check user email
    Route::match(['get', 'post'], '/check-email', 'UsersController@check_email');
    //wish list page
    Route::match(['get','post'],'/user/wish-list','ProductController@wish_list');
    //Wish List item delete
    Route::get('/user/wishList-delete/{id}', 'ProductController@delete_wishList');
    
});


Route::group(['middleware' => ['adminLogin']], function () {
    
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
    Route::get('/admin/delete-product-video/{id}', 'ProductController@delete_product_video');

    //Product Attributes

    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductController@add_attributes');
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}', 'ProductController@edit_attributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductController@delete_attributes');

    //Image attributes
    Route::match(['get', 'post'], '/admin/add-image/{id}', 'ProductController@add_attributes_image');
    Route::get('/admin/delete-image/{id}', 'ProductController@delete_image');

    //Coupons
    Route::match(['get', 'post'], '/admin/add-coupons', 'CuponsController@add_coupons');
    Route::match(['get', 'post'], '/admin/edit-coupons/{id}', 'CuponsController@edit_coupons');
    Route::get('/admin/view-coupons', 'CuponsController@view_coupons');
    Route::get('/admin/delete-coupons/{id}', 'CuponsController@delete_coupons');

    //banners
    Route::match(['get', 'post'], '/admin/add-banners', 'BannersController@add_banners');
    Route::match(['get', 'post'], '/admin/edit-banners/{id}', 'BannersController@edit_banners');
    Route::get('/admin/view-banners', 'BannersController@view_banners');
    Route::get('/admin/delete-banner-image/{id}', 'BannersController@delete_image_banners');
    Route::get('/admin/delete-banners/{id}', 'BannersController@delete_banners');
    
    //view order
    Route::get('/admin/view-orders','ProductController@view_orders');
    
    //view orders details
    Route::get('/admin/view-orders/{id}','ProductController@view_orders_details');
    
    //order invoice
    Route::get('/admin/view-orders-invoice/{id}','ProductController@view_orders_invoice');
    
    //order pdf invoice
    Route::get('/admin/view-pdf-invoice/{id}','ProductController@view_pdf_invoice');
    
    //update order status
    Route::post('/admin/update-order-status','ProductController@UpdateOrderStatus');
    
    // admin view users
    Route::get('/admin/view-users','UsersController@viewUsers');
    Route::get('/admin/delete-users/{id}','UsersController@delete_user');
    
    //admin and sub admins route
    Route::get('/admin/view-admins','AdminController@viewAdmins');
    Route::match(['get','post'],'/admin/add-admins','AdminController@addAdmins');
    Route::match(['get','post'],'/admin/edit-admins/{id}','AdminController@editAdmins');
    
    //admin cms pages
    Route::match(['get','post'],'/admin/add-cms-page','CmsController@addCms');
    Route::match(['get','post'],'/admin/edit_cms/{id}','CmsController@editCms');
    Route::get('/admin/view-cms-page','CmsController@viewCms');
    Route::get('/admin/delete-cms/{id}','CmsController@deleteCms');
    
    //admin currency page
    Route::match(['get','post'],'/admin/add-currency','CurrencyController@addCurrency');
    Route::match(['get','post'],'/admin/edit-currency/{id}','CurrencyController@editCurrency');
    Route::get('/admin/view-currency','CurrencyController@viewCurrency');
    Route::get('/admin/delete-currency/{id}','CurrencyController@deleteCurrency');
    
    //admin shipping charges
    Route::get('/admin/view-shipping','ShippingController@viewShipping');
    Route::match(['GET', 'POST'], '/admin/edit-shipping/{id}', 'ShippingController@edit');
    
    //admin subscriber for news letter
    Route::get('/admin/view-subscriber','NewsLetterSubscriberController@viewSubscriber');
    
    //admin newsletter status update
    Route::get('/admin/update-newsletter-status/{id}/{status}','NewsLetterSubscriberController@updateStatus');
    Route::get('/admin/delete-subscriber/{id}','NewsLetterSubscriberController@destroy');
    
    //admin export newsletter
    Route::get('/admin/export-newsletter-email','NewsLetterSubscriberController@exportNewsletter');
    
    //admin export users
    Route::get('/admin/export-users','UsersController@exportUsers');
    
    //admin export products
    Route::get('/admin/export-product','ProductController@exportProduct');
    
    //admin user charts routes
    Route::get('/admin/view-users/charts','UsersController@viewUserCharts');
    
});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
    
//display contact page
Route::match(['get','post'],'/page/contact','CmsController@cmsContact');

//display cms page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage');


