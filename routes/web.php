<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\monthController;

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



require __DIR__.'/auth.php';
