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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//admin routes
Route::post('/v1/admin/login','App\Http\Controllers\AdminController@login');
Route::post('/v1/admin/create','App\Http\Controllers\AdminController@register');

Route::post('/v1/admin/logout','App\Http\Controllers\AdminController@admin_logout');
Route::get('/v1/admin/user-listing','App\Http\Controllers\AdminController@user_listing');
Route::put('/v1/admin/user-edit/{uuid}','App\Http\Controllers\AdminController@edit_user');
Route::delete('/v1/admin/user-delete/{uuid}','App\Http\Controllers\AdminController@destroy');

//user routes
//Rout::get('api/v1/user','UserController@show');
/*Route::delete('api/v1/user','UserController@destroy');
Route::get('api/v1/user/orders','UserController@_user_orders');
Route::post('api/v1/user/create','UserController@create');
Route::post('api/v1/user/forgot-password','UserController@forget_password');
Route::post('api/v1/user/login','UserController@login');
Route::post('api/v1/user/logout','UserController@logout');
Route::post('api/v1/user/reset-password-token','UserController@reset_password_token');
Route::put('api/v1/user/edit','UserController@edit_user');*/
//category route
Route::get('/v1/categories','App\Http\Controllers\CategoryController@category_index');
Route::post('/v1/category/create','CategoryController@create');
Route::put('/v1/category/{uuid}','CategoryController@edit_category');
Route::get('/v1/category/{uuid}','CategoryController@category_show');
Route::delete('/v1/category/{uuid}','CategoryController@delete_category');
/*//Main Page route
Route::get('api/v1/main/blog','MainPageController@index_promotions');
Route::get('api/v1/main/blog/{uuid}','MainPageController@index_blog');
Route::get(' api/v1/main/promotions','MainPageController@show_post');
//product route 
Route::post('api/v1/product/create','ProductController@create');
Route::put('api/v1/product/{uuid}','ProductController@edit_product');
Route::get('api/v1/product/{uuid}','ProductController@product_show');
Route::delete('api/v1/product/{uuid}','ProductController@delete_product');
Route::get('api/v1/products','ProductController@category_index');
//order route
//brand route
Route::get('api/v1/brands','BrandController@brand_index');
Route::post('api/v1/brand/create','BrandController@create');
Route::put('api/v1/brand/{uuid}','BrandController@edit_brand');
Route::get('api/v1/brand/{uuid}','BrandController@brand_show');
Route::delete('api/v1/brand/{uuid}','BrandController@delete_brand');*/
//