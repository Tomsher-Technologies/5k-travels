<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FlightsApiController;

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

Route::get('change-currency/{currency}', [HomeController::class, 'changeCurrency'])->name('change-currency');

Route::get('search-airports', [HomeController::class, 'searchAirports'])->name('search-airports');

Route::get('autocomplete-airports', [HomeController::class, 'autocompleteAirports'])->name('autocomplete-airports');

Route::get('/flights/search', [FlightsController::class, 'search'])->name('flight.search');

Route::get('/flights/search-return', [FlightsController::class, 'searchReturn'])->name('flight.search-return');

Route::get('/flights/booking', [FlightsController::class, 'booking'])->name('flight.booking');

Route::post('/flights/create-booking', [FlightsController::class, 'createBooking'])->name('flight.create-booking');

Route::get('/flights/revalidate', [FlightsController::class, 'revalidate'])->name('flight.revalidate');
Route::get('/flight-view-details', [FlightsController::class, 'fightViewDetails'])->name('flight-view-details');

Route::post('web-post-login', [LoginController::class, 'postLogin'])->name('web.login.post');
Route::post('post-registration', [LoginController::class, 'postRegistration'])->name('register.post');
Route::post('web.forgot.password', [LoginController::class, 'submitForgetPassword'])->name('web.forgot.password');

Route::get('reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [LoginController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// Logout Routes...
Route::get('web-logout', [LoginController::class, 'logoutWeb'])->name('web.logout');


Route::get('/search-flights', [FlightsApiController::class, 'searchFlights'])->name('search-flights');
Route::get('/authorize', [FlightsApiController::class, 'getToken'])->name('authorize');


Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking-details/{type}/{id}', [HomeController::class, 'bookingDetails'])->name('booking-details');

    Route::get('/web-dashboard', [HomeController::class, 'dashboard'])->name('web-dashboard');
    Route::get('/cancelled', [HomeController::class, 'cancelled'])->name('cancelled');
    Route::get('/completed', [HomeController::class, 'completed'])->name('completed');
    Route::get('/upcoming', [HomeController::class, 'upcoming'])->name('upcoming');
    Route::get('/rescheduled', [HomeController::class, 'rescheduled'])->name('rescheduled');
    Route::get('/sub-agents', [HomeController::class, 'subAgents'])->name('sub-agents');
    Route::get('/credit-usage', [HomeController::class, 'creditUsage'])->name('credit-usage');

    Route::post('/change-agent-status', [HomeController::class, 'statusChange'])->name('change.agent.status');
    Route::get('/subagent-create', [HomeController::class, 'createSubAgent'])->name('subagent.create');
    Route::post('/subagent-store', [HomeController::class, 'storeSubAgent'])->name('subagent.store');
    Route::get('/subagent-edit/{agent}', [HomeController::class, 'editSubAgent'])->name('subagent.edit');
    Route::post('/subagent-update', [HomeController::class, 'updateSubAgent'])->name('subagent.update');
    Route::post('/subagent-delete', [HomeController::class, 'deleteSubAgent'])->name('subagent.delete');
    Route::get('/subagent-view/{agent}', [HomeController::class, 'viewSubAgent'])->name('subagent.view');
    Route::post('/agent-profile-update', [HomeController::class, 'updateAgentProfile'])->name('agent.profile.update');
    Route::get('/agent-profile', [HomeController::class, 'viewAgentProfile'])->name('agent.profile');

    Route::get('/flights/cancel', [FlightsController::class, 'cancelTicket'])->name('flight.cancel');
    Route::get('/flights/voidQuote', [FlightsController::class, 'voidQuote'])->name('flight.voidQuote');
    Route::post('/flights/void', [FlightsController::class, 'voidAPI'])->name('flight.void');
    Route::get('/flights/prtStatus', [FlightsController::class, 'ptrStatusCheck'])->name('flight.prtStatus');
    Route::get('/flights/refundQuote', [FlightsController::class, 'refundQuote'])->name('flight.refundQuote');
    Route::post('/flights/refund', [FlightsController::class, 'refundAPI'])->name('flight.refund');
    Route::get('/changeDate/{type}/{id}/{unique_id}', [FlightsController::class, 'changeDate'])->name('change-date');
    Route::post('/reschedule-flight', [FlightsController::class, 'rescheduleFlight'])->name('reschedule-flight');
    Route::post('/send-reschedule-request', [FlightsController::class, 'sendRescheduleRequest'])->name('send-reschedule-request');
    Route::get('/flights/reissue_prtStatus', [FlightsController::class, 'reissuePtrStatusCheck'])->name('flight.reissue_prtStatus');
});