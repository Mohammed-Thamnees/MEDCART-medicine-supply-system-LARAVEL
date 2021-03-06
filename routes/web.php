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

Auth::routes(['register'=>false]);
//Auth::routes();


Route::get('user/login','FrontendController@login')->name('login.form');
Route::post('user/login','FrontendController@loginSubmit')->name('login.submit');
Route::get('user/logout','FrontendController@logout')->name('user.logout');

Route::get('user/register','FrontendController@register')->name('register.form');
Route::post('user/register','FrontendController@registerSubmit')->name('register.submit');
// Reset password
//Route::get('password-reset', 'FrontendController@showResetForm')->name('password.reset');

// Socialite
Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');



Route::group(['middleware'=>['user']],function() {

    Route::get('/', 'FrontendController@home')->name('home');

// Frontend Routes
    Route::get('/home', 'FrontendController@index');
    Route::get('/about-us', 'FrontendController@aboutUs')->name('about-us');
    Route::get('/contact', 'FrontendController@contact')->name('contact');
    Route::post('/contact/message', 'MessageController@store')->name('contact.store');
    Route::get('/reply','MessageController@reply')->name('view.reply');
    Route::get('product-detail/{slug}', 'FrontendController@productDetail')->name('product-detail');
    Route::post('/product/search', 'FrontendController@productSearch')->name('product.search');
    Route::get('/product-cat/{slug}', 'FrontendController@productCat')->name('product-cat');
    Route::get('/product-sub-cat/{slug}/{sub_slug}', 'FrontendController@productSubCat')->name('product-sub-cat');
    Route::get('/product-brand/{slug}', 'FrontendController@productBrand')->name('product-brand');
// Cart section
    Route::get('/add-to-cart/{slug}', 'CartController@addToCart')->name('add-to-cart')->middleware('user');
    Route::post('/add-to-cart', 'CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
    Route::get('cart-delete/{id}', 'CartController@cartDelete')->name('cart-delete');
    Route::post('cart-update', 'CartController@cartUpdate')->name('cart.update');

    Route::get('/cart', function () {
        return view('frontend.pages.cart');
    })->name('cart');
    Route::get('/checkout', 'CartController@checkout')->name('checkout');


//razorpay
//Route::get('/start', 'PaymentController@index')->name('start');
//Route::get('/success', 'PaymentController@success');
//Route::post('/payments', 'PaymentController@payment')->name('payments');
//Route::post('/pay' , 'PaymentController@pay');
//Route::get('/error' , 'PaymentController@error');

// Wishlist
    Route::get('/wishlist', function () {
        return view('frontend.pages.wishlist');
    })->name('wishlist');
    Route::get('/wishlist/{slug}', 'WishlistController@wishlist')->name('add-to-wishlist')->middleware('user');
    Route::get('wishlist-delete/{id}', 'WishlistController@wishlistDelete')->name('wishlist-delete');
    Route::post('cart/order', 'OrderController@store')->name('cart.order');
    Route::get('order/pdf/{id}', 'OrderController@pdf')->name('order.pdf');
    Route::get('/income', 'OrderController@incomeChart')->name('product.order.income');
// Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
    Route::get('/product-grids', 'FrontendController@productGrids')->name('product-grids');
    Route::get('/product-lists', 'FrontendController@productLists')->name('product-lists');
    Route::match(['get', 'post'], '/filter', 'FrontendController@productFilter')->name('shop.filter');

// Blog
    Route::get('/blog', 'FrontendController@blog')->name('blog');
    Route::get('/blog-detail/{slug}', 'FrontendController@blogDetail')->name('blog.detail');
    Route::get('/blog/search', 'FrontendController@blogSearch')->name('blog.search');
    Route::post('/blog/filter', 'FrontendController@blogFilter')->name('blog.filter');
    Route::get('blog-cat/{slug}', 'FrontendController@blogByCategory')->name('blog.category');

// NewsLetter
    Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

// Coupon
    Route::post('/coupon-store', 'CouponController@couponStore')->name('coupon-store');
// Payment
//Route::get('payment', 'PayPalController@payment')->name('payment');
//Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
//Route::get('payment/success', 'PayPalController@success')->name('payment.success');

});




// Backend section start

Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/','AdminController@index')->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // user route
    Route::resource('users','UsersController');
    // Banner
    Route::resource('banner','BannerController');
    // Brand
    Route::resource('brand','BrandController');
    //delivery boy
    Route::resource('/deliveryboys','DeliveryBoyController');
    //delivery work
    Route::resource('/deliveryworks','DeliveryWorkController');
    Route::get('/deliveryworks/assign/{id}/{oid}','DeliveryWorkController@assign')->name('assign');
    Route::get('/deliveryworks/works','DeliveryWorkController@work')->name('work');
    //Shops purchase history
    Route::get('/shopview','UserHistoryController@index')->name('userhistory');
    Route::get('/shoporder/{id}','UserHistoryController@orders')->name('userorders');
    Route::get('/shopproduct/{id}','UserHistoryController@products')->name('userproducts');
    //Sales Report
    Route::get('/report','UserHistoryController@report')->name('report');
    // Profile
    Route::get('/profile','AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');
    // Category
    Route::resource('/category','CategoryController');
    // Product
    Route::resource('/product','ProductController');
    // Ajax for sub category
    Route::post('/category/{id}/child','CategoryController@getChildByParent');
    // POST category
    Route::resource('/post-category','PostCategoryController');
    // Post
    Route::resource('/post','PostController');
    // Message
    Route::resource('/message','MessageController');
    Route::get('/message/five','MessageController@messageFive')->name('messages.five');

    // Order
    Route::resource('/order','OrderController');
    Route::get('/order/return/{id}','OrderController@return')->name('order.return');
    Route::get('/order/return/db/{id}','OrderController@boys')->name('return.boys');
    Route::get('/order/return/assign/{id}/{oid}','OrderController@assign')->name('return.assign');
    // Shipping
    Route::resource('/shipping','ShippingController');
    // Coupon
    Route::resource('/coupon','CouponController');
    // Settings
    Route::get('settings','AdminController@settings')->name('settings');
    Route::post('setting/update','AdminController@settingsUpdate')->name('settings.update');

    // Notification
    Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');
    Route::get('/notifications','NotificationController@index')->name('all.notification');
    Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});










// User section start
Route::group(['prefix'=>'/user','middleware'=>['user']],function(){
    Route::get('/','HomeController@index')->name('user');
     // Profile
     Route::get('/profile','HomeController@profile')->name('user-profile');
     Route::post('/profile/{id}','HomeController@profileUpdate')->name('user-profile-update');
    //  Order
    Route::get('/order',"HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}',"HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}','HomeController@userOrderDelete')->name('user.order.delete');
    Route::post('/order/cancel/{id}','HomeController@userOrderCancel')->name('user.order.cancel');
    Route::post('/order/return/{id}','HomeController@userOrderReturn')->name('user.order.return');
    // Product Review
    Route::get('/user-review','HomeController@productReviewIndex')->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}','HomeController@productReviewDelete')->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}','HomeController@productReviewEdit')->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}','HomeController@productReviewUpdate')->name('user.productreview.update');

    // Post comment
    Route::get('user-post/comment','HomeController@userComment')->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}','HomeController@userCommentDelete')->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}','HomeController@userCommentEdit')->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}','HomeController@userCommentUpdate')->name('user.post-comment.update');

    // Password Change
    Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
    Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//Delivery boy section
Route::group(['middleware'=>['user']],function() {

    Route::get('db/delivery','DeliveryBoyController@dbhome')->name('db.home');
    Route::get('db/pickup','DeliveryBoyController@pickup')->name('db.pickup');
    Route::get('db/product/{id}','DeliveryBoyController@order')->name('db.order');
    Route::get('db/status/{id}','DeliveryBoyController@status')->name('db.status');
    Route::get('db/return/product/{id}','DeliveryBoyController@returnorder')->name('db.return.order');
    Route::get('db/return/status/{id}','DeliveryBoyController@returnstatus')->name('db.return.status');

});
