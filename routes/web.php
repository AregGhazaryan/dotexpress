<?php

// Guest Routes
Auth::routes();
Route::get('/', 'PagesController@index')->name('home');
Route::get('/category/{machine_name}', 'CategoryController@index')->name('categories.show');
Route::get('/locations', 'PagesController@locations');
Route::get('/message', 'PagesController@message');
Route::post('/carts/{id}/store', 'CartsController@store')->name('carts.store');
Route::get('/checkout', 'CartsController@checkout')->name('carts.checkout');
Route::get('checkout/empty', 'CartsController@empty')->name('carts.empty');
Route::delete('checkout/delete/{id}', 'CartsController@destroy')->name('carts.destroy');
Route::get('search', 'ProductsController@search')->name('search');
Route::get('/products/{unique_id}', 'ProductsController@show')->name('products.show');
Route::get('/customerservice', 'PagesController@service');
Route::resource('wish', 'WishlistController');
Route::resource('products', 'ProductsController');
Route::get('category/{machine_name}/sort', 'CategoryController@sort')->name('sort');
Route::get('/product/{id}/add', 'PostsController@addtocart')->name('add');
Route::get('/terms', 'PagesController@terms')->name('terms');
Route::get('/privacy', 'PagesController@privacy')->name('privacy');
Route::get('/howitworks', 'PagesController@howitworks')->name('how-it-works');
Route::get('/disclaimer', 'PagesController@disclaimer')->name('disclaimer');
Route::get('/releases', 'PagesController@releases')->name('releases');
Route::get('/contact', 'PagesController@contact')->name('contact-us');
Route::post('/contact', 'PagesController@send');

// Auth routes
Route::group(['middleware' => ['auth']], function () {
  Route::get('/profile/{id}', 'PagesController@profile')->name('profile');
  Route::post('/products/buy', 'ProductsController@buy')->name('products.buy');
  Route::post('/products/buy-now', 'ProductsController@buyNow')->name('products.buy-now');
  Route::get('/wish/{id}', 'PostsController@wish')->name('wish');
  Route::get('/wish/index/{id}', 'PostsController@wishindex')->name('wishindex');


  // Admin or seller routes
  Route::group(['middleware' => ['admin_or_seller']], function () {
    Route::get('/order/approve/{id}', 'OrderController@approve')->name('orders.approve');
    Route::get('/products/create', 'ProductsController@create')->name('products.create');
    Route::post('/products/store', 'ProductsController@store')->name('products.store');
    Route::delete('/products/{id}/delete', 'ProductsController@destroy')->name('products.destroy');
  });

  // Admin Routes
  Route::group(['middleware' => ['admin']], function () {
    Route::get('/send/{id}', 'EmailController@send');
    Route::get('/profile/delete/{id}', 'PagesController@deleteprofile')->name('profile.delete');
    Route::get('/approve/{id}', 'ProductsController@approve')->name('products.approve');
  });
});
