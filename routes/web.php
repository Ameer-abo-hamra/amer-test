<?php

use App\Http\Controllers\StorekeeperController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicationController;
// use App\Http\Controllers\;
use App\Http\Controllers\ReqController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get(
    "get-token",
    function () {
        return response()->json([
            "status" => true,
            "csrf_token" => csrf_token(),
            'statusNumber' => 200

        ]);
    }
);

Route::post("login", [StorekeeperController::class, "login"])->name("login");


Route::group(['middleware' => 'authuser'], function () {

    Route::get("logout", [StorekeeperController::class, 'logout']);

    Route::post("add-medicine", [MedicationController::class, "addMedicine"]);

    Route::get("show-reqs", [ReqController::class, "allRequests"]);

    Route::post("change-state", [ReqController::class, "changeState"])->name("change");

    Route::get("payments-report", [ReqController::class, "paymentsReport"]);

    Route::get("request-owner/{req_id}", [ReqController::class, "requestOwner"]);

});
