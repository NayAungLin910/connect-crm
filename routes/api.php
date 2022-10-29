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

// org
Route::get('/org/view', [\App\Http\Controllers\AdminMod\Api\OrganizationController::class, "getOrg"]);
Route::post('/org/delete', [\App\Http\Controllers\AdminMod\Api\OrganizationController::class, "deleteOrg"]);
Route::post('/org/delete-multiple', [\App\Http\Controllers\AdminMod\Api\OrganizationController::class, "deleteOrgMultiple"]);
// contact
Route::get('/contact/view', [\App\Http\Controllers\AdminMod\Api\ContactController::class, "getContact"]);
Route::post('/contact/delete', [\App\Http\Controllers\AdminMod\Api\ContactController::class, "deleteContact"]);
Route::post('/contact/delete-multiple', [\App\Http\Controllers\AdminMod\Api\ContactController::class, "deleteContactMultiple"]);
// source
Route::get('/source/view', [\App\Http\Controllers\AdminMod\Api\SourceController::class, "getSource"]);
Route::post('/source/delete', [\App\Http\Controllers\AdminMod\Api\SourceController::class, "deleteSource"]);
Route::post('/source/delete-multiple', [\App\Http\Controllers\AdminMod\Api\SourceController::class, "deleteSourceMultiple"]);
// product
Route::get('/product/view', [\App\Http\Controllers\AdminMod\Api\ProductController::class, "getProduct"]);
Route::post('/product/delete', [\App\Http\Controllers\AdminMod\Api\ProductController::class, "deleteProduct"]);
Route::post('/product/delete-multiple', [\App\Http\Controllers\AdminMod\Api\ProductController::class, "deleteProductMultiple"]);
// business
Route::get('/business/view', [\App\Http\Controllers\AdminMod\Api\BusinessController::class, "getBusiness"]);
Route::post('/business/delete', [\App\Http\Controllers\AdminMod\Api\BusinessController::class, "deleteBusiness"]);
Route::post('/business/delete-multiple', [\App\Http\Controllers\AdminMod\Api\BusinessController::class, "deleteBusinessMultiple"]);
// lead
Route::get('/lead/view', [\App\Http\Controllers\AdminMod\Api\LeadController::class, "getLead"]);
Route::post('/lead/delete', [\App\Http\Controllers\AdminMod\Api\LeadController::class, "deleteLead"]);
Route::post('/lead/delete-multiple', [\App\Http\Controllers\AdminMod\Api\LeadController::class, "deleteLeadMultiple"]);
// activity
Route::get('/activity/view', [\App\Http\Controllers\AdminMod\Api\ActivityController::class, "getActivity"]);
Route::post('/activity/done', [\App\Http\Controllers\AdminMod\Api\ActivityController::class, "doneActivity"]);
Route::post('/activity/delete', [\App\Http\Controllers\AdminMod\Api\ActivityController::class, "deleteActivity"]);
// home page charts
Route::get('/yearbar-data', [\App\Http\Controllers\AdminMod\Api\HomeController::class, "getYearBarData"]);
Route::get('/lead-pie-data', [\App\Http\Controllers\AdminMod\Api\HomeController::class, "getLeadPieData"]);
Route::get('/top-lead-data', [\App\Http\Controllers\AdminMod\Api\HomeController::class, "getTopLeadData"]);
Route::get('/revenue-lead-data', [\App\Http\Controllers\AdminMod\Api\HomeController::class, "getRevenueLeadData"]);
// account management
Route::get('/account/get-data', [\App\Http\Controllers\AdminMod\Api\AccountManageController::class, "getDatatAccount"]); 
Route::post('/account/delete', [\App\Http\Controllers\AdminMod\Api\AccountManageController::class, "postDeleteAccount"]);
Route::post('/account/delete-multiple', [\App\Http\Controllers\AdminMod\Api\AccountManageController::class, "postDeleteAccountMultiple"]);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
