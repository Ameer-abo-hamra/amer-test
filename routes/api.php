<?php

use App\Http\Controllers\MedicationController;
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
Route::post("login" , [PharController::class , "login"]);

Route::post("logout" , [PharController::class , "logout"]);

Route::get("browse-medication" , [MedicationController::Class ,"browseMedications"]);



Route::post("add-medicine" , [MedicationController::class , "addMedicine"]);
