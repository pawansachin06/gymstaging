<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CitiesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BusinessesController;
use App\Http\Controllers\Admin\ListingsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\BoostController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\CouponproductController;
use App\Http\Controllers\Admin\VerificationCouponController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProductOrderController as AdminProductOrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Webhook\StripeController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('contact', [HomePageController::class, 'getContactForm'])->name('contact');
Route::post('contact', [HomePageController::class, 'sendEmail'])->name('contact.sendmail');
Route::get('page/{slug}', [HomePageController::class, 'getCMSPage'])->name('cms');
Route::get('legals', [HomePageController::class, 'legalPage'])->name('legals');
Route::get('get_users', [HomePageController::class, 'getUsers'])->name('getusers');
Route::get('partners', [HomePageController::class, 'partners'])->name('partner');
Route::get('searchname', [HomePageController::class, 'searchGym'])->name('searchname');
Route::get('about', [HomePageController::class, 'aboutUs'])->name('aboutus');
Route::get('testemail/{bid?}', [HomePageController::class, 'testEmail'])->name('testemail');
Route::get('facebook/reviews', [HomePageController::class, 'get_facebook_reviews'])->name('facebook.reviews');
Route::post('load/google_rev', [HomePageController::class, 'load_google_rev'])->name('load.google_rev');
Route::post('connect/google', [HomePageController::class, 'google_connect'])->name('connect.google');
Route::post('load/fb_rev', [HomePageController::class, 'load_fb_rev'])->name('load.fb_rev');
Route::post('connect/fb', [HomePageController::class, 'fb_connect'])->name('connect.fb');
Route::post('delete/reviews', [HomePageController::class, 'delete_reviews'])->name('delete.reviews');
Route::post('save/filter', [HomePageController::class, 'save_filter'])->name('save.filter');
Route::get('google/reviews', [HomePageController::class, 'get_google_reviews'])->name('google.reviews');
Route::get('fb/reviews', [HomePageController::class, 'get_fb_reviews'])->name('fb.reviews');
Route::get('join/personal', [HomePageController::class, 'personalRegister'])->name('join.personal');
Route::post('join/personal', [HomePageController::class, 'storePersonalUser'])->name('store.personal.user');
Route::get('join', [HomePageController::class, 'selectBusiness'])->name('select.business');
Route::get('join/business/{type?}/{status?}', [HomePageController::class, 'businessRegister'])->name('join.business');
Route::post('join/validate/coupon', [HomePageController::class, 'validateBusinessCoupon'])->name('validate.business.coupon');
Route::post('join/validate/{type}', [HomePageController::class, 'validateBusinessForm'])->name('validate.business.user');
Route::post('join/business/{type}', [HomePageController::class, 'storeBusinessUser'])->name('store.business.user');
Route::get('search', [HomePageController::class, 'table'])->name('search');
Route::get('businesses/{category}', [HomePageController::class, 'category'])->name('category');
Route::get('filter/category', [HomePageController::class, 'listingCategoryFilter'])->name('listing.category_filter');
Route::post('emails/reviewnotification', [HomePageController::class, 'showMailNotifications'])->name('emails.reviewnotification');
Route::get('payments', [HomePageController::class, 'showPayments'])->name('payments');
Route::get('verify/token/{id}',[HomePageController::class, 'verifyToken'])->name('verify.token');
Route::post('validate/verifycoupon', [HomePageController::class, 'validateVerificationCoupon'])->name('validate.verify.coupon');

Route::get('autosearch', [HomePageController::class, 'autoSearch'])->name('autosearch.listing');
Route::get('getmap', [HomePageController::class, 'getMap'])->name('map.listing');
Route::get('updateform', [HomePageController::class, 'getUpdateForm'])->name('user.updateform');
Route::post('update_profile', [HomePageController::class, 'UpdateUserProfile'])->name('user.updateprofile');
Route::get('read_notification/{id}', [HomePageController::class, 'readNotification'])->name('user.read_notification');
Route::get('listing_create/notification', [HomePageController::class, 'sendListingCreateEmail'])->name('listingcreate.notification');
Route::post('dropzone/upload', [HomePageController::class, 'dropzoneUpload'])->name('dropzone.upload');

//User Impersonation
Route::impersonate();

// Authentication Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.login');
Route::get('web-admin', [LoginController::class, 'showLoginForm'])->name('auth.admin-login');
Route::post('login', [LoginController::class, 'login'])->name('auth.login');
Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');

// Change Password Routes...
Route::get('change_password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('auth.change_password');
Route::patch('change_password', [ChangePasswordController::class, 'changePassword'])->name('auth.change_password');

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.password.reset');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('auth.password.reset');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('auth.password.reset');
Route::post('report/abuse', [HomePageController::class, 'reportAbuse'])->name('report.abuse');

//Stripe Webhooks
Route::post('stripe/webhook', [StripeController::class, 'handleWebhook']);

//Products
Route::get('products', [ProductController::class, 'index'])->name('products');
Route::get('product/detail/{product_id}', [ProductController::class, 'productDetails'])->name('product.details');
Route::get('product/checkout/{product_id}', [ProductController::class, 'productOrderNow'])->name('product.order_now');
Route::post('product/applycouponcode', [ProductController::class, 'productApplyCouponCode'])->name('product.applycouponcode');
Route::post('product/order/create/{product_id}', [ProductOrderController::class, 'createProductOrder'])->name('product.order.create');
Route::get('product/order/response/{reference_id}', [ProductOrderController::class, 'stripe3dResponse'])->name('product.order.stripe3dResponse');

Route::group(['middleware' => 'auth'], function () {
    Route::get('account/edit', [HomePageController::class, 'accountEdit'])->name('account.edit');
    Route::get('account/payments', [HomePageController::class, 'accountPayments'])->name('account.payments');
    Route::get('account/charges', [HomePageController::class, 'accountCharges'])->name('account.charges');
    Route::post('account/savecard', [HomePageController::class, 'saveCard'])->name('account.savecard');
    Route::get('account/removecard/{cardId}', [HomePageController::class, 'removeCard'])->name('account.removecard');
    Route::get('account/defaultcard/{cardId}', [HomePageController::class, 'defaultCard'])->name('account.defaultcard');
    Route::get('business/edit', [HomePageController::class, 'businessRegister'])->name('business.edit');
    Route::get('business/{id}/{status}', [HomePageController::class, 'businessStatus'])->name('business.status');

    Route::get('business/boost', [HomePageController::class, 'businessBoost'])->name('business.boost');
    Route::post('business/{id}/boost', [HomePageController::class, 'businessBoosted'])->name('business.boosted');

    Route::get('business/location-boost', [HomePageController::class, 'businessLocationBoost'])->name('business.locationboost');
    Route::post('business/save-locations', [HomePageController::class, 'saveLocations'])->name('business.saveLocations');

    Route::post('business/location-boost', [HomePageController::class, 'doBusinessLocationBoost'])->name('business.dolocationboost');
    Route::get('business/location-boost-cities', [HomePageController::class, 'businessLocationBoostCityFast'])->name('business.businesslocationboostcity');
    Route::get('business/location-boost-cities-old', [HomePageController::class, 'businessLocationBoostCity'])->name('business.businesslocationboostcityold');

    Route::get('business/getcities', [HomePageController::class, 'getCity'])->name('business.getcities');

    Route::get('business/verify', [HomePageController::class, 'businessVerify'])->name('business.verify');
    Route::post('business/verify/upload', [HomePageController::class, 'businessVerifyUpload'])->name('business.verify.upload');
    Route::post('business/{id}/verification', [HomePageController::class, 'businessVerification'])->name('business.verification');
    Route::post('listings/{slug}/review', [HomePageController::class, 'storeReview'])->name('listings.reviewstore');
    Route::get('listing/review_edit', [HomePageController::class, 'editReview'])->name('listing.reviewedit');
    Route::post('profile/update', [HomePageController::class, 'updateUserProfile'])->name('user.updateprofile');
    Route::get('review/notification', [HomePageController::class, 'showNotifications'])->name('review.notification');
});

Route::group(['middleware' => ['auth','role:3'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('product-orders', [AdminProductOrderController::class, 'index'])->name('product_order.index');
    Route::get('product-orders/{id}', [AdminProductOrderController::class, 'show'])->name('product_order.show');
    Route::get('product-orders/mark-as-completed/{id}', [AdminProductOrderController::class, 'markAsCompleted'])->name('product_order.mark_as_completed');
    Route::get('home', [HomeController::class, 'index'])->name('home');

    //Roles and Users
    Route::post('roles_mass_destroy', [RolesController::class, 'massDestroy'])->name('roles.mass_destroy');
    Route::post('users_mass_destroy', [UsersController::class, 'massDestroy'])->name('users.mass_destroy');

    //Cities
    Route::post('cities_mass_destroy', [CitiesController::class, 'massDestroy'])->name('cities.mass_destroy');
    Route::post('cities_restore/{id}', [CitiesController::class, 'restore'])->name('cities.restore');
    Route::delete('cities_perma_del/{id}', [CitiesController::class, 'perma_del'])->name('cities.perma_del');

    //Businesses
    Route::post('businesses_mass_destroy', [BusinessesController::class, 'massDestroy'])->name('businesses.mass_destroy');
    Route::post('businesses_restore/{id}', [BusinessesController::class, 'restore'])->name('businesses.restore');
    Route::delete('businesses_perma_del/{id}', [BusinessesController::class, 'perma_del'])->name('businesses.perma_del');
    Route::get('businesses/plan', [BusinessesController::class, 'planIndex'])->name('businesses.plan_management');
    Route::post('businesses/plan', [BusinessesController::class, 'storePlanManagement'])->name('businesses.plan_store');

    //Listings
    Route::post('listings_mass_destroy', [ListingsController::class, 'massDestroy'])->name('listings.mass_destroy');
    Route::post('listings_restore/{id}', [ListingsController::class, 'restore'])->name('listings.restore');
    Route::delete('listings_perma_del/{id}', [ListingsController::class, 'perma_del'])->name('listings.perma_del');
    Route::get('payment/{id}', ['uses' => [ListingsController::class, 'paymentListing'], 'as' => 'listings.payment']);
    Route::get('listings_review/{id}', [ListingsController::class, 'showReviewForm'])->name('listings.review');
    Route::post('listings_review/{id}', [ListingsController::class, 'storeReview'])->name('listings.reviewstore');
    Route::get('review_delete/{id}', [ListingsController::class, 'deleteReview'])->name('listings.reviewdelete');
    Route::get('listing_verify/{id}', [ListingsController::class, 'verify'])->name('listings.verify');
    Route::post('updateBrand', [ListingsController::class, 'updateBrand'])->name('listings.updateBrand');

    Route::get('listings/edit/{id}', [HomePageController::class, 'businessRegister'])->name('business.edit');
    Route::post('listings/save/{id}', [HomePageController::class, 'storeBusinessUser'])->name('business.store');
    Route::get('report_abuse', [ListingsController::class, 'reportAbuse'])->name('review.report_abuse');
    Route::delete('report_abuse_delete/{id}/{type}', [ListingsController::class, 'reportAbuseDelete'])->name('report.delete');

    Route::match(['get','post'],'/settings/{slug}', [SettingsController::class, 'index'])->name('settings');
    Route::get('setting/about-us', [SettingsController::class, 'setAboutUs'])->name('settings.aboutus');
    Route::get('update_profile', [SettingsController::class, 'showUpdateProfileForm'])->name('settings.profile');
    Route::patch('update_profile', [SettingsController::class, 'updateProfile'])->name('settings.update_profile');
    Route::get('change_password', [SettingsController::class, 'showChangePasswordForm'])->name('settings.change_password');
    Route::patch('change_password', [SettingsController::class, 'changePassword'])->name('settings.change_password');

    //Categories
    Route::get('category/type_list/{id}', [CategoryController::class, 'type_list'])->name('category.type_list');
    Route::post('categories_mass_destroy', [CategoryController::class, 'massDestroy'])->name('category.mass_destroy');
    Route::post('categories_restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('categories_perma_del/{id}', [CategoryController::class, 'perma_del'])->name('category.perma_del');

    //Amenities
    Route::get('amenity/type_list/{id}', [AmenityController::class, 'type_list'])->name('amenity.type_list');
    Route::post('amenity_mass_destroy', [AmenityController::class, 'massDestroy'])->name('amenity.mass_destroy');
    Route::post('mass_restore', [AmenityController::class, 'massRestore'])->name('amenity.mass_restore');
    Route::post('amenity_restore/{id}', [AmenityController::class, 'restore'])->name('amenity.restore');
    Route::delete('amenity_perma_del/{id}', [AmenityController::class, 'perma_del'])->name('amenity.perma_del');

    //Verification
    Route::get('verification/type_list/{id}', [VerificationController::class, 'type_list'])->name('verification.type_list');
    Route::post('verification_mass_destroy', [VerificationController::class, 'massDestroy'])->name('verification.mass_destroy');
    Route::post('verification_restore/{id}', [VerificationController::class, 'restore'])->name('verification.restore');
    Route::delete('verification_perma_del/{id}', [VerificationController::class, 'perma_del'])->name('verification.perma_del');
    Route::get('listing/{id}/verifying/{status}', [VerificationController::class, 'verifying'])->name('verification.verifying');

    //Boosted
    Route::get('boost/type_list/{id}', [BoostController::class, 'type_list'])->name('boost.type_list');
    Route::post('boost_mass_destroy', [BoostController::class, 'massDestroy'])->name('boost.mass_destroy');
    Route::post('boost_restore/{id}', [BoostController::class, 'restore'])->name('boost.restore');
    Route::delete('boost_perma_del/{id}', [BoostController::class, 'perma_del'])->name('boost.perma_del');
    Route::get('listing/{id}/boost/{status}', [BoostController::class, 'verifying'])->name('boost.verifying');

    //SEO
    Route::get('seo/type_list/{id}', [SeoMetaController::class, 'type_list'])->name('seo.type_list');
    Route::post('seo_mass_destroy', [SeoMetaController::class, 'massDestroy'])->name('seo.mass_destroy');
    Route::post('seo_restore/{id}', [SeoMetaController::class, 'restore'])->name('seo.restore');
    Route::delete('seo_perma_del/{id}', [SeoMetaController::class, 'perma_del'])->name('seo.perma_del');

    //Product Coupons
    Route::get('pcoupon/type_list/{id}', [CouponproductController::class, 'type_list'])->name('pcoupon.type_list');
    Route::post('pcoupon_mass_destroy', [CouponproductController::class, 'massDestroy'])->name('pcoupon.mass_destroy');
    Route::post('pcoupon_restore/{id}', [CouponproductController::class, 'restore'])->name('pcoupon.restore');
    Route::delete('pcoupon_perma_del/{id}', [CouponproductController::class, 'perma_del'])->name('pcoupon.perma_del');

    //Products
    Route::get('products/type_list/{id}', [ProductsController::class, 'type_list'])->name('products.type_list');
    Route::post('products_mass_destroy', [ProductsController::class, 'massDestroy'])->name('products.mass_destroy');
    Route::post('products_restore/{id}', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('products_perma_del/{id}', [ProductsController::class, 'perma_del'])->name('products.perma_del');

    //Sponsors
    Route::post('sponsors/update_data', [SponsorController::class, 'updataData'])->name('sponsors.update_data');
    //Coupon
    Route::post('verificationcoupon/toggle', [VerificationCouponController::class, 'toggleCoupon'])->name('verificationcoupon.toggle');

    //Resources
    Route::resources([
        'roles' => RolesController::class,
        'users' => UsersController::class,
        'cities' => CitiesController::class,
        'businesses' => BusinessesController::class,
        'listings' => ListingsController::class,
        'category' => CategoryController::class,
        'amenity' => AmenityController::class,
        'verification' => VerificationController::class,
        'boost' => BoostController::class,
        'seo' => SeoMetaController::class,
        'coupon' => CouponController::class,
        'verificationcoupon' => VerificationCouponController::class,
        'partner' => PartnerController::class,
        'faq' => FaqController::class,
        'pcoupon' => CouponproductController::class,
        'products' => ProductsController::class,
        'sponsors' => SponsorController::class,
    ]);
});

Route::get('{slug}', [HomePageController::class, 'listing'])->name('listing.view');