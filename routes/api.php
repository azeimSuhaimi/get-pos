<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\employeeApiController;

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

Route::controller(employeeApiController::class)->group(function () {

    Route::get('/employee/index/{email}','index');
    Route::post('/employee/show','show');
    Route::post('/employee/store/','store');
    Route::post('/employee/delete','destroy');
    Route::post('/employee/update','update');
    Route::post('/employee/update_image','update_image');
    Route::post('/employee/remove_image','remove_image');

    
    Route::post('/store','store')->middleware(['auth:sanctum']);
    Route::patch('/update/{id}','update')->middleware(['auth:sanctum']);
    Route::delete('/destroy/{id}','destroy')->middleware(['auth:sanctum']);
    

});//end group


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
