<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/{slug?}', function () {

    return redirect('/admin/employee');

})->where('slug','(|admin)');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('employee/data',[EmployeeController::class, 'data'])->name('employee.data');
    Route::resource('employee', EmployeeController::class);

});

Route::get('/project-init', function () {
    return Artisan::call('project:init');
});
