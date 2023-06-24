<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightsController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('search-airports',[HomeController::class,'searchAirports'])->name('search-airports');

Route::get('/flights/search', [FlightsController::class, 'search'])->name('flight.search');

Route::get('/flights/search-return', [FlightsController::class, 'searchReturn'])->name('flight.search-return');

Route::get('/flights/booking', [FlightsController::class, 'booking'])->name('flight.booking');

Route::post('/flights/create-booking', [FlightsController::class, 'createBooking'])->name('flight.create-booking');

Route::get('/web-dashboard', [HomeController::class, 'dashboard'])->name('web-dashboard');

Auth::routes();

Route::group(['middleware' => ['auth','web']], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

