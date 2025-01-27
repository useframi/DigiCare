<?php

use Illuminate\Support\Facades\Route;
use Modules\Vital\Http\Controllers\Backend\VitalsController;

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
/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['auth']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Vitals Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'vitals', 'as' => 'vitals.'],function () {
      Route::get("index_list", [VitalsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [VitalsController::class, 'index_data'])->name("index_data");
      Route::get('export', [VitalsController::class, 'export'])->name('export');
    });
    Route::resource("vitals", VitalsController::class);
});

