<?php

 Route::get('/', 'HomePageController@index')->name('home');
 Route::get('contact', 'HomePageController@getContactForm')->name('contact');
 Route::post('contact', 'HomePageController@sendEmail')->name('contact.sendmail');
 Route::get('page/{slug}', 'HomePageController@getCMSPage')->name('cms');
 Route::get('legals', 'HomePageController@legalPage')->name('legals');
 Route::get('/get_users', 'HomePageController@getUsers')->name('getusers');
 Route::get('partners', 'HomePageController@partners')->name('partner');
 Route::get('searchname', 'HomePageController@searchGym')->name('searchname');
 Route::get('about', 'HomePageController@aboutUs')->name('aboutus');
 Route::get('testemail/{bid?}', 'HomePageController@testEmail')->name('testemail');

 Route::get('/facebook/reviews', 'HomePageController@get_facebook_reviews')->name('facebook.reviews');
 Route::post('/load/google_rev', 'HomePageController@load_google_rev')->name('load.google_rev');
 Route::post('/connect/google', 'HomePageController@google_connect')->name('connect.google');
 Route::post('/load/fb_rev', 'HomePageController@load_fb_rev')->name('load.fb_rev');
 Route::post('/connect/fb', 'HomePageController@fb_connect')->name('connect.fb');
 Route::post('/delete/reviews', 'HomePageController@delete_reviews')->name('delete.reviews');
 Route::post('/save/filter', 'HomePageController@save_filter')->name('save.filter');
 Route::get('/google/reviews', 'HomePageController@get_google_reviews')->name('google.reviews');
 Route::get('/fb/reviews', 'HomePageController@get_fb_reviews')->name('fb.reviews');
 Route::get('/join/personal', 'HomePageController@personalRegister')->name('join.personal');
 Route::post('/join/personal', 'HomePageController@storePersonalUser')->name('store.personal.user');
 Route::get('/join', 'HomePageController@selectBusiness')->name('select.business');
 Route::get('/join/business/{type?}/{status?}', 'HomePageController@businessRegister')->name('join.business');
 Route::post('/join/validate/coupon', 'HomePageController@validateBusinessCoupon')->name('validate.business.coupon');
 Route::post('/join/validate/{type}', 'HomePageController@validateBusinessForm')->name('validate.business.user');
 Route::post('/join/business/{type}', 'HomePageController@storeBusinessUser')->name('store.business.user');
 Route::get('search', 'HomePageController@table')->name('search');
 Route::get('businesses/{category}', 'HomePageController@category')->name('category');
 Route::get('filter/category', 'HomePageController@listingCategoryFilter')->name('listing.category_filter');
 Route::post('emails/reviewnotification', 'HomePageController@showMailNotifications')->name('emails.reviewnotification');
 Route::get('/payments', 'HomePageController@showPayments')->name('payments');
 Route::get('/verify/token/{id}','HomePageController@verifyToken')->name('verify.token');
 Route::post('validate/verifycoupon', 'HomePageController@validateVerificationCoupon')->name('validate.verify.coupon');

 Route::get('autosearch','HomePageController@autoSearch')->name('autosearch.listing');
 Route::get('getmap','HomePageController@getMap')->name('map.listing');
 Route::get('/updateform','HomePageController@getUpdateForm')->name('user.updateform');
 Route::post('/update_profile','HomePageController@UpdateUserProfile')->name('user.updateprofile');
 Route::get('/read_notification/{id}','HomePageController@readNotification')->name('user.read_notification');
 Route::get('listing_create/notification', 'HomePageController@sendListingCreateEmail')->name('listingcreate.notification');
 Route::post('/dropzone/upload', 'HomePageController@dropzoneUpload')->name('dropzone.upload');


 //User Impersonation
 Route::impersonate();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::get('web-admin', 'Auth\LoginController@showLoginForm')->name('auth.admin-login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');
Route::post('report/abuse','HomePageController@reportAbuse')->name('report.abuse');


//Stripe Webhooks
Route::post('stripe/webhook','Webhook\StripeController@handleWebhook');

//Products
Route::get('/products', 'ProductController@index')->name('products');
Route::get('/product/detail/{product_id}', 'ProductController@productDetails')->name('product.details');
Route::get('/product/checkout/{product_id}', 'ProductController@productOrderNow')->name('product.order_now');
Route::post('/product/applycouponcode', 'ProductController@productApplyCouponCode')->name('product.applycouponcode');
Route::post('/product/order/create/{product_id}', 'ProductOrderController@createProductOrder')->name('product.order.create');
Route::get('/product/order/response/{reference_id}', 'ProductOrderController@stripe3dResponse')->name('product.order.stripe3dResponse');

Route::group(['middleware' => 'auth'], function () {
    Route::get('account/edit', 'HomePageController@accountEdit')->name('account.edit');
    Route::get('account/payments', 'HomePageController@accountPayments')->name('account.payments');
    Route::get('account/charges', 'HomePageController@accountCharges')->name('account.charges');
    Route::post('account/savecard', 'HomePageController@saveCard')->name('account.savecard');
    Route::get('account/removecard/{cardId}', 'HomePageController@removeCard')->name('account.removecard');
    Route::get('account/defaultcard/{cardId}', 'HomePageController@defaultCard')->name('account.defaultcard');
    Route::get('business/edit', 'HomePageController@businessRegister')->name('business.edit');
    Route::get('business/{id}/{status}', 'HomePageController@businessStatus')->name('business.status');

    Route::get('business/boost', 'HomePageController@businessBoost')->name('business.boost');
    Route::post('business/{id}/boost','HomePageController@businessBoosted')->name('business.boosted');

    Route::get('business/location-boost', 'HomePageController@businessLocationBoost')->name('business.locationboost');
    
    Route::post('business/save-locations', 'HomePageController@saveLocations')->name('business.saveLocations');

    Route::post('business/location-boost', 'HomePageController@doBusinessLocationBoost')->name('business.dolocationboost');
    Route::get('business/location-boost-cities', 'HomePageController@businessLocationBoostCityFast')->name('business.businesslocationboostcity');
    Route::get('business/location-boost-cities-old', 'HomePageController@businessLocationBoostCity')->name('business.businesslocationboostcityold');

    Route::get('business/getcities', 'HomePageController@getCity')->name('business.getcities');

    Route::get('business/verify', 'HomePageController@businessVerify')->name('business.verify');
    Route::post('business/verify/upload', 'HomePageController@businessVerifyUpload')->name('business.verify.upload');
    Route::post('business/{id}/verification','HomePageController@businessVerification')->name('business.verification');
    Route::post('listings/{slug}/review', ['uses' => 'HomePageController@storeReview', 'as' => 'listings.reviewstore' ]);
    Route::get('listing/review_edit', ['uses' => 'HomePageController@editReview', 'as' => 'listing.reviewedit' ]);
    Route::post('profile/update','HomePageController@updateUserProfile')->name('user.updateprofile');
    Route::get('review/notification', 'HomePageController@showNotifications')->name('review.notification');
});

Route::group(['middleware' => ['auth','role:3'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('product-orders', 'Admin\ProductOrderController@index')->name('product_order.index');
    Route::get('product-orders/{id}', 'Admin\ProductOrderController@show')->name('product_order.show');
    Route::get('product-orders/mark-as-completed/{id}', 'Admin\ProductOrderController@markAsCompleted')->name('product_order.mark_as_completed');
    Route::get('/home', 'HomeController@index')->name('home');

    //Roles and Users
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    //Cities
    Route::post('cities_mass_destroy', ['uses' => 'Admin\CitiesController@massDestroy', 'as' => 'cities.mass_destroy']);
    Route::post('cities_restore/{id}', ['uses' => 'Admin\CitiesController@restore', 'as' => 'cities.restore']);
    Route::delete('cities_perma_del/{id}', ['uses' => 'Admin\CitiesController@perma_del', 'as' => 'cities.perma_del']);

    //Businesses
    Route::post('businesses_mass_destroy', ['uses' => 'Admin\BusinessesController@massDestroy', 'as' => 'businesses.mass_destroy']);
    Route::post('businesses_restore/{id}', ['uses' => 'Admin\BusinessesController@restore', 'as' => 'businesses.restore']);
    Route::delete('businesses_perma_del/{id}', ['uses' => 'Admin\BusinessesController@perma_del', 'as' => 'businesses.perma_del']);
    Route::get('businesses/plan', ['uses' => 'Admin\BusinessesController@planIndex', 'as' => 'businesses.plan_management']);
    Route::post('businesses/plan', ['uses' => 'Admin\BusinessesController@storePlanManagement', 'as' => 'businesses.plan_store']);

    //Listings
    Route::post('listings_mass_destroy', ['uses' => 'Admin\ListingsController@massDestroy', 'as' => 'listings.mass_destroy']);
    Route::post('listings_restore/{id}', ['uses' => 'Admin\ListingsController@restore', 'as' => 'listings.restore']);
    Route::delete('listings_perma_del/{id}', ['uses' => 'Admin\ListingsController@perma_del', 'as' => 'listings.perma_del']);
    Route::get('payment/{id}', ['uses' => 'Admin\ListingsController@paymentListing', 'as' => 'listings.payment']);
    Route::get('listings_review/{id}', ['uses' => 'Admin\ListingsController@showReviewForm', 'as' => 'listings.review']);
    Route::post('listings_review/{id}', ['uses' => 'Admin\ListingsController@storeReview', 'as' => 'listings.reviewstore']);
    Route::get('review_delete/{id}', ['uses' => 'Admin\ListingsController@deleteReview', 'as' => 'listings.reviewdelete']);
    Route::get('listing_verify/{id}', ['uses' => 'Admin\ListingsController@verify', 'as' => 'listings.verify']);
    Route::post('updateBrand', ['uses' => 'Admin\ListingsController@updateBrand', 'as' => 'listings.updateBrand']);

    Route::get('listings/edit/{id}', 'HomePageController@businessRegister')->name('business.edit');
    Route::post('listings/save/{id}', 'HomePageController@storeBusinessUser')->name('business.store');
    Route::get('report_abuse', ['uses' => 'Admin\ListingsController@reportAbuse', 'as' => 'review.report_abuse']);
    Route::delete('report_abuse_delete/{id}/{type}', ['uses' => 'Admin\ListingsController@reportAbuseDelete', 'as' => 'report.delete']);



    Route::match(['get','post'],'/settings/{slug}', 'Admin\SettingsController@index')->name('settings');
    Route::get('setting/about-us', 'Admin\SettingsController@setAboutUs')->name('settings.aboutus');
    Route::get('update_profile', 'Admin\SettingsController@showUpdateProfileForm')->name('settings.profile');
    Route::patch('update_profile', 'Admin\SettingsController@updateProfile')->name('settings.update_profile');
    Route::get('change_password', 'Admin\SettingsController@showChangePasswordForm')->name('settings.change_password');
    Route::patch('change_password', 'Admin\SettingsController@changePassword')->name('settings.change_password');


    //Categories
    Route::get('category/type_list/{id}', ['uses' => 'Admin\CategoryController@type_list', 'as' => 'category.type_list']);
    Route::post('categories_mass_destroy', ['uses' => 'Admin\CategoryController@massDestroy', 'as' => 'category.mass_destroy']);
    Route::post('categories_restore/{id}', ['uses' => 'Admin\CategoryController@restore', 'as' => 'category.restore']);
    Route::delete('categories_perma_del/{id}', ['uses' => 'Admin\CategoryController@perma_del', 'as' => 'category.perma_del']);

    //Amenities
    Route::get('amenity/type_list/{id}', ['uses' => 'Admin\AmenityController@type_list', 'as' => 'amenity.type_list']);
    Route::post('amenity_mass_destroy', ['uses' => 'Admin\AmenityController@massDestroy', 'as' => 'amenity.mass_destroy']);
    Route::post('mass_restore', ['uses' => 'Admin\AmenityController@massRestore', 'as' => 'amenity.mass_restore']);
    Route::post('amenity_restore/{id}', ['uses' => 'Admin\AmenityController@restore', 'as' => 'amenity.restore']);
    Route::delete('amenity_perma_del/{id}', ['uses' => 'Admin\AmenityController@perma_del', 'as' => 'amenity.perma_del']);

    //Verification
    Route::get('verification/type_list/{id}', ['uses' => 'Admin\VerificationController@type_list', 'as' => 'verification.type_list']);
    Route::post('verification_mass_destroy', ['uses' => 'Admin\VerificationController@massDestroy', 'as' => 'verification.mass_destroy']);
    Route::post('verification_restore/{id}', ['uses' => 'Admin\VerificationController@restore', 'as' => 'verification.restore']);
    Route::delete('verification_perma_del/{id}', ['uses' => 'Admin\VerificationController@perma_del', 'as' => 'verification.perma_del']);
    Route::get('listing/{id}/verifying/{status}', ['uses' => 'Admin\VerificationController@verifying', 'as' => 'verification.verifying']);

    //Boosted
    Route::get('boost/type_list/{id}', ['uses' => 'Admin\BoostController@type_list', 'as' => 'boost.type_list']);
    Route::post('boost_mass_destroy', ['uses' => 'Admin\BoostController@massDestroy', 'as' => 'boost.mass_destroy']);
    Route::post('boost_restore/{id}', ['uses' => 'Admin\BoostController@restore', 'as' => 'boost.restore']);
    Route::delete('boost_perma_del/{id}', ['uses' => 'Admin\BoostController@perma_del', 'as' => 'boost.perma_del']);
    Route::get('listing/{id}/boost/{status}', ['uses' => 'Admin\BoostController@verifying', 'as' => 'boost.verifying']);

    //SEO
    Route::get('seo/type_list/{id}', ['uses' => 'Admin\SeoMetaController@type_list', 'as' => 'seo.type_list']);
    Route::post('seo_mass_destroy', ['uses' => 'Admin\SeoMetaController@massDestroy', 'as' => 'seo.mass_destroy']);
    Route::post('seo_restore/{id}', ['uses' => 'Admin\SeoMetaController@restore', 'as' => 'seo.restore']);
    Route::delete('seo_perma_del/{id}', ['uses' => 'Admin\SeoMetaController@perma_del', 'as' => 'seo.perma_del']);

    //Product Coupons
    Route::get('pcoupon/type_list/{id}', ['uses' => 'Admin\CouponproductController@type_list', 'as' => 'pcoupon.type_list']);
    Route::post('pcoupon_mass_destroy', ['uses' => 'Admin\CouponproductController@massDestroy', 'as' => 'pcoupon.mass_destroy']);
    Route::post('pcoupon_restore/{id}', ['uses' => 'Admin\CouponproductController@restore', 'as' => 'pcoupon.restore']);
    Route::delete('pcoupon_perma_del/{id}', ['uses' => 'Admin\CouponproductController@perma_del', 'as' => 'pcoupon.perma_del']);

    //Products
    Route::get('products/type_list/{id}', ['uses' => 'Admin\ProductsController@type_list', 'as' => 'products.type_list']);
    Route::post('products_mass_destroy', ['uses' => 'Admin\ProductsController@massDestroy', 'as' => 'products.mass_destroy']);
    Route::post('products_restore/{id}', ['uses' => 'Admin\ProductsController@restore', 'as' => 'products.restore']);
    Route::delete('products_perma_del/{id}', ['uses' => 'Admin\ProductsController@perma_del', 'as' => 'products.perma_del']);

    //Sponsors
    Route::post('sponsors/update_data', ['uses' => 'Admin\SponsorController@updataData', 'as' => 'sponsors.update_data']);
    //Coupon
    Route::post('verificationcoupon/toggle','Admin\VerificationCouponController@toggleCoupon')->name('verificationcoupon.toggle');

    //Resources
    Route::resources([
        'roles' => 'Admin\RolesController',
        'users' => 'Admin\UsersController',
        'cities' => 'Admin\CitiesController',
        'businesses' => 'Admin\BusinessesController',
        'listings' => 'Admin\ListingsController',
        'category' => 'Admin\CategoryController',
        'amenity' => 'Admin\AmenityController',
        'verification' => 'Admin\VerificationController',
        'boost' => 'Admin\BoostController',
        'seo' => 'Admin\SeoMetaController',
        'coupon' => 'Admin\CouponController',
        'verificationcoupon' => 'Admin\VerificationCouponController',
        'partner' => 'Admin\PartnerController',
        'faq' => 'Admin\FaqController',
        'pcoupon' => 'Admin\CouponproductController',
        'products' => 'Admin\ProductsController',
        'sponsors' => 'Admin\SponsorController'
    ]);
});

Route::get('{slug}', 'HomePageController@listing')->name('listing.view');