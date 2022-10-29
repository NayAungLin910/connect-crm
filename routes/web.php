<?php

use Illuminate\Support\Facades\App;
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



// before authentication
Route::middleware(['NotAuth'])->group(function () {
    // admin
    Route::get('/login-admin', [\App\Http\Controllers\AuthController::class, "adminLogin"]);
    Route::post('/login-admin', [\App\Http\Controllers\AuthController::class, "postAdminLogin"]);
    Route::get('/register-admin', [\App\Http\Controllers\AuthController::class, "adminRegister"]);
    Route::post('/register-admin', [\App\Http\Controllers\AuthController::class, "postAdminRegister"]);
    // moderator
    Route::get('/login-moderator', [\App\Http\Controllers\AuthController::class, "moderatorLogin"]);
    Route::post('/login-moderator', [\App\Http\Controllers\AuthController::class, "postModeratorLogin"]);
    Route::get('/register-moderator', [\App\Http\Controllers\AuthController::class, "moderatorRegister"]);
    Route::post('/register-moderator', [\App\Http\Controllers\AuthController::class, "postModeratorRegister"]);
});

// after authentication
Route::middleware(['AuthOnly'])->group(function () {
    // profile
    Route::get('/profile', [\App\Http\Controllers\AdminMod\ProfileController::class, "profile"]);
    Route::get('/edit-profile', [\App\Http\Controllers\AdminMod\ProfileController::class, "editProfile"]);
    Route::post('/edit-profile', [\App\Http\Controllers\AdminMod\ProfileController::class, "postEditProfile"]);
    Route::get('/change-password', [\App\Http\Controllers\AdminMod\ProfileController::class, "changePassword"]);
    Route::post('/change-password', [\App\Http\Controllers\AdminMod\ProfileController::class, "postChangePassword"]);
    Route::middleware(['AdminOnly'])->group(function () {
        Route::get('/account-manage/search', [\App\Http\Controllers\AdminMod\ProductController::class, "searchAccount"]);
    });
    // homepage
    Route::get('/', [\App\Http\Controllers\AdminMod\HomeController::class, "home"]);
    // logout
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, "logout"]);
    // org
    Route::get('/org/create', [\App\Http\Controllers\AdminMod\OrganizationController::class, "createOrg"]);
    Route::post('/org/create', [\App\Http\Controllers\AdminMod\OrganizationController::class, "postCreateOrg"]);
    Route::get('/org/view', [\App\Http\Controllers\AdminMod\OrganizationController::class, "viewOrg"]);
    Route::get('/org/edit/{slug}', [\App\Http\Controllers\AdminMod\OrganizationController::class, "editOrg"]);
    Route::post('/org/edit', [\App\Http\Controllers\AdminMod\OrganizationController::class, "postEditOrg"]);
    // contact
    Route::get('/contact/create', [\App\Http\Controllers\AdminMod\ContactController::class, "createContact"]);
    Route::post('/contact/create', [\App\Http\Controllers\AdminMod\ContactController::class, "postCreateContact"]);
    Route::get('/contact/view', [\App\Http\Controllers\AdminMod\ContactController::class, "viewContact"]);
    Route::get('/contact/edit/{slug}', [\App\Http\Controllers\AdminMod\ContactController::class, "editContact"]);
    Route::post('/contact/edit', [\App\Http\Controllers\AdminMod\ContactController::class, "postEditContact"]);
    // source
    Route::get('/source/create', [\App\Http\Controllers\AdminMod\SourceController::class, "createSource"]);
    Route::post('/source/create', [\App\Http\Controllers\AdminMod\SourceController::class, "postCreateSource"]);
    Route::get('/source/view', [\App\Http\Controllers\AdminMod\SourceController::class, "viewSource"]);
    Route::get('/source/edit/{slug}', [\App\Http\Controllers\AdminMod\SourceController::class, "editSource"]);
    Route::post('/source/edit', [\App\Http\Controllers\AdminMod\SourceController::class, "postEditSource"]);
    // product
    Route::get('/product/create', [\App\Http\Controllers\AdminMod\ProductController::class, "createProduct"]);
    Route::post('/product/create', [\App\Http\Controllers\AdminMod\ProductController::class, "postCreateProduct"]);
    Route::get('/product/view', [\App\Http\Controllers\AdminMod\ProductController::class, "viewProduct"]);
    Route::get('/product/edit/{slug}', [\App\Http\Controllers\AdminMod\ProductController::class, "editProdcut"]);
    Route::post('/product/edit/{slug}', [\App\Http\Controllers\AdminMod\ProductController::class, "postEditProdcut"]);
    // business
    Route::get('/business/create', [\App\Http\Controllers\AdminMod\BusinessController::class, "createBusiness"]);
    Route::post('/business/create', [\App\Http\Controllers\AdminMod\BusinessController::class, "postCreateBusiness"]);
    Route::get('/business/view', [\App\Http\Controllers\AdminMod\BusinessController::class, "viewBusiness"]);
    Route::get('/business/edit/{slug}', [\App\Http\Controllers\AdminMod\BusinessController::class, "editBusiness"]);
    Route::post('/business/edit/{slug}', [\App\Http\Controllers\AdminMod\BusinessController::class, "postEditBusiness"]);
    // lead
    Route::get('/lead/create', [\App\Http\Controllers\AdminMod\LeadController::class, "createLead"]);
    Route::post('/lead/create', [\App\Http\Controllers\AdminMod\LeadController::class, "postCreateLead"]);
    Route::get('/lead/view', [\App\Http\Controllers\AdminMod\LeadController::class, "viewLead"]);
    Route::get('/lead/edit/{slug}', [\App\Http\Controllers\AdminMod\LeadController::class, "editLead"]);
    Route::post('/lead/edit/{slug}', [\App\Http\Controllers\AdminMod\LeadController::class, "postEditLead"]);
    Route::get('/lead/download/{year}', [\App\Http\Controllers\AdminMod\LeadController::class, "downloadLead"]);
    // activity
    Route::get('/activity/create/{slug}', [\App\Http\Controllers\AdminMod\ActivityController::class, "createActivity"]);
    Route::post('/activity/create', [\App\Http\Controllers\AdminMod\ActivityController::class, "postCreateActivity"]);
    Route::get('/activity/edit/{slug}', [\App\Http\Controllers\AdminMod\ActivityController::class, "editActivity"]);
    Route::post('/activity/edit/{slug}', [\App\Http\Controllers\AdminMod\ActivityController::class, "postEditActivity"]);
    Route::get('/activity/view', [\App\Http\Controllers\AdminMod\ActivityController::class, "viewActivity"]);
});
