<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\monthController;
use App\Http\Controllers\AppointmentController;

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

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('calendar', [monthController::class, 'index']);
Route::post('loadInputData', [monthController::class, 'loadThings']);

Route::get('listAppointments', [AppointmentController::class, 'index'])->name('listAppointments');
Route::get('addAppointment', [AppointmentController::class, 'addAppointment'])->name('addAppointment');
Route::post('saveAppointment', [AppointmentController::class, 'saveAppointment'])->name('saveAppointment');
Route::get('editAppointment/{id}', [AppointmentController::class, 'editAppointment'])->name('editAppointment');
Route::post('updateAppointment', [AppointmentController::class, 'updateAppointment'])->name('updateAppointment');
Route::get('deleteAppointment/{id}', [AppointmentController::class, 'deleteAppointment'])->name('deleteAppointment');



require __DIR__.'/auth.php';
