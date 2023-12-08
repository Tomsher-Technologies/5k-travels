<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AgentsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
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
Route::namespace('Admin')->prefix('admin')->group(function () {

    // Login Routes...
    Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('loginpost', [AdminLoginController::class, 'login'])->name('admin.loginpost');

    // Logout Routes...
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // // Registration Routes...
    // Route::get('register', 'RegisterController@showRegistrationForm')->name('admin.register');
    // Route::post('register', 'RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('admin.password.update');

    // Password Confirmation Routes...
    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('admin.password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');

    // // Email Verification Routes...
    // Route::get('email/verify', 'VerificationController@show')->name('admin.verification.notice');
    // Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('admin.verification.verify');
    // Route::post('email/resend', 'VerificationController@resend')->name('admin.verification.resend');

    Route::group(['middleware' => ['auth','admin']], function () {
        
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard-counts', [HomeController::class, 'dashboardCounts'])->name('dashboard-counts');
        Route::get('/allusers-counts', [HomeController::class, 'allUsersCounts'])->name('allusers-counts');
        Route::get('/flightbooking-counts', [HomeController::class, 'flightbookingCounts'])->name('flightbooking-counts');

        /* ------------------- Agents -----------------*/
        Route::get('/agent', [AgentsController::class, 'index'])->name('agent.index');
        Route::get('/agent/create', [AgentsController::class, 'create'])->name('agent.create');
        Route::post('/agent/store', [AgentsController::class, 'store'])->name('agent.store');
        Route::get('/agent/edit/{agent}', [AgentsController::class, 'edit'])->name('agent.edit');
        Route::post('/agent/update', [AgentsController::class, 'update'])->name('agent.update');
        Route::post('/agent/delete/', [AgentsController::class, 'delete'])->name('agent.delete');
        Route::get('/agent/view/{agent}', [AgentsController::class, 'view'])->name('agent.view');
        Route::post('/agent/approve', [AgentsController::class, 'approve'])->name('agent.approve');
        Route::post('/agent/change-status', [AgentsController::class, 'statusChange'])->name('agent.change.status');
        Route::get('/agent/graph', [AgentsController::class, 'agentGraph'])->name('agent.graph');
        
        /* ------------------- Users -----------------*/
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
        Route::post('/user/delete/', [UserController::class, 'delete'])->name('user.delete');
        Route::get('/user/view/{user}', [UserController::class, 'view'])->name('user.view');
        Route::post('/user/change-status', [UserController::class, 'statusChange'])->name('user.change.status');

        /* ------------------- Flights -----------------*/
        Route::get('/flights/airports', [FlightController::class, 'storeAirport'])->name('flights.airports');
        Route::get('/flights/airlines', [FlightController::class, 'storeAirlines'])->name('flights.airlines');
        Route::get('/flights/airlines/update', [FlightController::class, 'updateAirlineImages'])->name('flights.airlines.update');

        /* ------------------- General Settings -----------------*/
        Route::get('/settings/general', [HomeController::class, 'generalSettings'])->name('settings.general');
        Route::post('/settings/general/store', [HomeController::class, 'generalSettingsStore'])->name('settings.general.store');

        Route::get('/settings/pages', [HomeController::class, 'pages'])->name('settings.pages');
        Route::get('/settings/pages/edit/{page}', [HomeController::class, 'updatePages'])->name('settings.pages.edit');
        Route::post('/settings/pages/update', [HomeController::class, 'savePages'])->name('settings.pages.update');
        Route::get('/settings/faq', [HomeController::class, 'faq'])->name('settings.faq');
        Route::get('/settings/faq/create', [HomeController::class, 'faqCreate'])->name('settings.faq.create');
        Route::post('/settings/faq/store', [HomeController::class, 'faqStore'])->name('settings.faq.store');
        Route::get('/settings/faq/edit/{faq}', [HomeController::class, 'faqEdit'])->name('settings.faq.edit');
        Route::post('/settings/faq/update', [HomeController::class, 'faqUpdate'])->name('settings.faq.update');
        Route::post('/settings/faq/delete', [HomeController::class, 'faqDelete'])->name('settings.faq.delete');
        Route::post('/faq/change-status', [HomeController::class, 'faqStatusChange'])->name('faq.change.status');
        Route::post('/faq/delete/', [HomeController::class, 'deleteFaq'])->name('faq.category.delete');

        Route::get('/flight-bookings', [HomeController::class, 'getAllBookings'])->name('bookings');
        Route::get('/booking-view/{id}', [HomeController::class, 'getBookingDetails'])->name('booking.view');
        Route::get('/flight-bookings-export', [HomeController::class, 'exportData'])->name('export');
        
    });
});
