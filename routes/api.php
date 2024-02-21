<?php

use App\Http\Controllers\MedicationController;
use App\Http\Controllers\ReqController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("register", [PharController::Class, "register"]);

Route::post("login", [PharController::class, "login"]);

Route::group(["middleware" => "CustomAuthorization"], function () {

    Route::post("logout", [PharController::class, "logout"]);

    Route::get("browse-medication", [MedicationController::Class, "browseMedications"]);

    Route::post("search", [MedicationController::class, "search"]);

    Route::get('show-details/{med_id}', [MedicationController::class, "showDetails"]);

    Route::post("add-req", [ReqController::class, "addReq"]);

    Route::get("show-requests", [ReqController::class, "showRequests"]);

    Route::get("add-to-favorites/{med_id}" , [PharController::class , "addToFavorite"]);

    Route::get("request-report" , [PharController::class , "requestReport"]);

    Route::get("request-details/{request_id}" , [PharController::class , "requestDetails"]);
});






