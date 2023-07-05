<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/flights/revalidate', [FlightsController::class, 'revalidate'])->name('flight.revalidate');

Route::post('web-post-login', [LoginController::class, 'postLogin'])->name('web.login.post');
// Logout Routes...
Route::get('web-logout', [LoginController::class, 'logoutWeb'])->name('web.logout');

Route::get('/web-dashboard', [HomeController::class, 'dashboard'])->name('web-dashboard');

Route::get('/flights/cancel', [FlightsController::class, 'cancelTicket'])->name('flight.cancel');
Route::get('/flights/voidQuote', [FlightsController::class, 'voidQuote'])->name('flight.voidQuote');
Route::post('/flights/void', [FlightsController::class, 'voidAPI'])->name('flight.void');
Route::get('/flights/prtStatus', [FlightsController::class, 'ptrStatusCheck'])->name('flight.prtStatus');
Route::get('/flights/refundQuote', [FlightsController::class, 'refundQuote'])->name('flight.refundQuote');
Route::post('/flights/refund', [FlightsController::class, 'refundAPI'])->name('flight.refund');

Route::group(['middleware' => ['auth','web']], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

