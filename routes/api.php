<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/v1/admin/login','App\Http\Controllers\AdminController@login');
Route::post('/v1/admin/create','App\Http\Controllers\AdminController@register');
Route::group(['middleware' => ['auth:api', 'admin']], function () {
	Route::post('/v1/admin/logout','App\Http\Controllers\AdminController@admin_logout');
Route::get('/v1/admin/user-listing','App\Http\Controllers\AdminController@user_listing');
Route::put('/v1/admin/user-edit/{uuid}','App\Http\Controllers\AdminController@edit_user');
Route::delete('/v1/admin/user-delete/{uuid}','App\Http\Controllers\AdminController@destroy');
	//categories
    Route::get('/v1/categories','App\Http\Controllers\CategoryController@category_index');
Route::post('/v1/category/create','App\Http\Controllers\CategoryController@create');
Route::put('/v1/category/{uuid}','App\Http\Controllers\CategoryController@edit_category');
Route::get('/v1/category/{uuid}','App\Http\Controllers\CategoryController@category_show');
Route::delete('/v1/category/{uuid}','App\Http\Controllers\CategoryController@delete_category');
  //Main Page route
Route::get('/v1/main/blog','App\Http\Controllers\MainPageController@index_promotions');
Route::get('/v1/main/blog/{uuid}','App\Http\Controllers\MainPageController@index_blog');
Route::get('/v1/main/promotions','App\Http\Controllers\MainPageController@show_post');
//product route
Route::post('/v1/product/create','App\Http\Controllers\ProductController@create');
Route::put('/v1/product/{uuid}','App\Http\Controllers\ProductController@edit_product');
Route::get('/v1/product/{uuid}','App\Http\Controllers\ProductController@product_show');
Route::delete('/v1/product/{uuid}','App\Http\Controllers\ProductController@delete_product');
Route::get('/v1/products','App\Http\Controllers\ProductController@product_index');
  Route::get('/v1/orders','App\Http\Controllers\OrderController@all_order_list');
Route::get('/v1/orders/shipment-locator','App\Http\Controllers\OrderController@shipment_locator');
Route::get('/v1/orders/dashboard','App\Http\Controllers\OrderController@dashboard_order');
Route::get('/v1/brands','App\Http\Controllers\BrandController@brand_index');
Route::post('/v1/brand/create','App\Http\Controllers\BrandController@create');
Route::put('/v1/brand/{uuid}','App\Http\Controllers\BrandController@edit_brand');
Route::get('/v1/brand/{uuid}','App\Http\Controllers\BrandController@brand_show');
Route::delete('/v1/brand/{uuid}','App\Http\Controllers\BrandController@delete_brand');
//Order Status-------
Route::get('/v1/order-statuses','App\Http\Controllers\OrderStatusController@orderstatus_index');
Route::post('/v1/order-status/create','App\Http\Controllers\OrderStatusController@create');
Route::put('/v1/order-status/{uuid}','App\Http\Controllers\OrderStatusController@edit_orderstatus');
Route::get('/v1/order-status/{uuid}','App\Http\Controllers\OrderStatusController@orderstatus_show');
Route::delete('/v1/order-status/{uuid}','App\Http\Controllers\OrderStatusController@delete_orderstatus');
//Payment ------
Route::get('/v1/payments','App\Http\Controllers\PaymentController@payment_index');
Route::post('/v1/payments/create','App\Http\Controllers\PaymentController@create');
Route::put('/v1/payments/{uuid}','App\Http\Controllers\PaymentController@edit_payment');
Route::get('/v1/payments/{uuid}','App\Http\Controllers\PaymentController@payment_show');
Route::delete('/v1/payments/{uuid}','App\Http\Controllers\PaymentController@delete_payment');
//files----------
Route::get('/v1/file/upload','App\Http\Controllers\FilesController@upload');
Route::post('/v1/file/{uuid}','App\Http\Controllers\FilesControllerController@getfile');
});
//admin routes

Route::post('/v1/user/create','App\Http\Controllers\UserController@register');
Route::post('/v1/user/login','App\Http\Controllers\UserController@login');
Route::group(['middleware' => ['auth:api']], function () {

//user routes
Route::get('/v1/user','UserController@show');
Route::delete('/v1/user','App\Http\Controllers\UserController@destroy');
Route::get('/v1/user/orders','App\Http\Controllers\UserController@user_orders');
Route::post('/v1/user/forgot-password','App\Http\Controllers\UserController@forget_password');
Route::post('/v1/user/logout','App\Http\Controllers\UserController@logout');
Route::post('/v1/user/reset-password-token','App\Http\Controllers\UserController@reset_password_token');
Route::put('/v1/user/edit','App\Http\Controllers\UserController@edit_user');

Route::post('/v1/order/create','App\Http\Controllers\OrderController@create_order');
 Route::put('/v1/order/{uuid}','App\Http\Controllers\OrderController@edit_order');
 Route::get('/v1/order/{uuid}','App\Http\Controllers\OrderController@show_order');
 Route::delete('/v1/order/{uuid}','App\Http\Controllers\OrderController@delete_order');
});

