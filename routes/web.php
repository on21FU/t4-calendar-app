<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\monthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MonthSelectionController;

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
    return redirect('listAppointments');
})->middleware(['auth', 'verified'])->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('listAppointments', [AppointmentController::class, 'index'])->middleware(['auth', 'verified'])->name('listAppointments');
Route::post('listAppointments', [AppointmentController::class, 'index'])->middleware(['auth', 'verified'])->name('listAppointments');
Route::get('addAppointment', [AppointmentController::class, 'addAppointment'])->middleware(['auth', 'verified'])->name('addAppointment');
Route::post('saveAppointment', [AppointmentController::class, 'saveAppointment'])->middleware(['auth', 'verified'])->name('saveAppointment');
Route::get('editAppointment/{id}', [AppointmentController::class, 'editAppointment'])->middleware(['auth', 'verified'])->name('editAppointment');
Route::post('updateAppointment', [AppointmentController::class, 'updateAppointment'])->middleware(['auth', 'verified'])->name('updateAppointment');
Route::get('deleteAppointment/{id}', [AppointmentController::class, 'deleteAppointment'])->middleware(['auth', 'verified'])->name('deleteAppointment');
Route::get('get-appointments-bydate', [AppointmentController::class, 'getAppointmentsByDate'])->middleware(['auth', 'verified'])->name('get-appointments-bydate');

Route::post('inputSelectedMonth', [MonthSelectionController::class, 'inputSelectedMonth'])->middleware(['auth', 'verified'])->name('inputSelectedMonth');
Route::post('inputSelectedYear', [MonthSelectionController::class, 'inputSelectedYear'])->middleware(['auth', 'verified'])->name('inputSelectedYear');
Route::get('getLastSelection', [MonthSelectionController::class, 'getLastSelection'])->middleware(['auth', 'verified'])->name('getLastSelection');



require __DIR__.'/auth.php';
