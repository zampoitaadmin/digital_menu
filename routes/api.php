<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController as DefaultProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BrandingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MerchantFixedMenuController;

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('auth/connect-sso', [AuthController::class, 'authenticate']);
#Route::post('login', [ApiController::class, 'authenticate']);
#Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    // custom-menu/categories
    // http://local.zampoita.com/custom-menu/categories
    // custom-menu/products
    Route::get('categories', [CategoryController::class, 'getAllWithUser']);
    Route::get('categories-user', [CategoryController::class, 'getAllOnlyByUser']);
    Route::get('user-selected-categories', [CategoryController::class, 'getUserSelectedCategories']);
    Route::get('all-allergies', [CategoryController::class, 'getAllAllergies']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::delete('categories/{category}',  [CategoryController::class, 'destroy']);
    Route::put('categories/{category}',  [CategoryController::class, 'update']);
    Route::post('categories/update-user-category-order',  [CategoryController::class, 'updateUserCategoryOrder']);
    Route::post('categories/assign', [CategoryController::class, 'assignCategory']);
    #Route::resource('categories', [CategoryController::class]);

    Route::post('merchant-fixed-menu', [MerchantFixedMenuController::class, 'store']);
    Route::get('merchant-fixed-menu/{category}', [MerchantFixedMenuController::class, 'getMerchantFixedMenu']);
    Route::put('merchant-fixed-menu/{merchantFixedMenuData}',  [MerchantFixedMenuController::class, 'update']);

    Route::get('products', [ProductController::class, 'getUserSelectedCategoriesProducts']);
    Route::post('products', [ProductController::class, 'store']);
    Route::post('product-image', [ProductController::class, 'storeProductImage']);
    Route::put('products/{product}',  [ProductController::class, 'update']);
    Route::delete('products/{product}',  [ProductController::class, 'destroy']);
    Route::delete('product-image/{product}',  [ProductController::class, 'removeProductImage']);
    Route::post('products/update-user-category-product-order',  [ProductController::class, 'updateUserCategoryProductOrder']);
    Route::put('remove-product-main-image/{product}', [ProductController::class, 'removeProductMainImage']);

    Route::get('branding-by-user', [BrandingController::class, 'getOneByUserId']);
    Route::get('branding-logo', [BrandingController::class, 'getBrandingLogo']);
    Route::put('branding-by-user/{menuBranding}', [BrandingController::class, 'update']);
    Route::put('branding-revert-default/{menuBranding}', [BrandingController::class, 'revertToDefault']);
    Route::post('branding-logo', [BrandingController::class, 'storeBrandingLogo']);
    Route::put('remove-branding-logo/{menuBranding}', [BrandingController::class, 'removeBrandingLogo']);

    Route::get('setting-by-user', [UserController::class, 'getSettingByUser']);
    Route::post('setting-by-user', [UserController::class, 'updateSetting']);

    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);

    // Route::get('products', [TestController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::put('update/{product}',  [ProductController::class, 'update']);
    Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});