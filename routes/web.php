<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


Route::get('/', 'PagesController@index');
Route::get('/category/{name}', 'CategoryController@index');
Route::get('/product/{id}', 'CategoryController@product');
Route::get('/create', 'PostsController@index');
Route::get('/locations', 'PagesController@locations');
Route::get('/message', 'PagesController@message');
Route::resource('posts','PostsController');
Route::get('category/{category}/sort', 'CategoryController@sort')->name('sort');
Route::get('/customerservice', 'PagesController@service');
Route::get('/profile/{id}', 'PagesController@profile');
Route::get('/add/{id}/{quantity}','PostsController@add')->name('add');
Route::get('/checkout','PagesController@checkout');
Route::get('checkout/forget','PostsController@forget');
Route::get('checkout/delete/{id}','PostsController@del');
Route::get('search','PostsController@search')->name('search');
Route::get('/product/{id}/add','PostsController@addtocart')->name('add');
Route::get('/wish/{id}','PostsController@wish')->name('wish');
Route::get('/wish/index/{email}','PostsController@wishindex')->name('wishindex');
Route::get('/wish/delete/{email}','PostsController@wishdelete')->name('wishdelete');
Route::post('/buy','OrderController@buy')->name('buy');
Route::get('/approve/{id}','PostsController@approve');
Route::get('/order/approve/{id}','PostsController@approveorder');
Route::get('/profile/delete/{id}','PagesController@deleteprofile');
Route::get('/terms','PagesController@terms');
Route::get('/send/{id}', 'EmailController@send');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/howitworks', 'PagesController@howitworks');
Route::get('/contact', 'PagesController@contact');
Route::post('/contact', 'PagesController@send');
Route::get('/releases', function(){
  return view('pages.releases');
});
Route::post('/checkout/buy', 'PostsController@checkoutbuy');
Auth::routes();
