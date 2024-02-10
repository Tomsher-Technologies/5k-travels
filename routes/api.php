<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/generate-password', [ApiController::class, 'generatePassword'])->name('generate-password');

    Route::post('/airport_list', [ApiController::class, 'airportList'])->name('airport_list');
    Route::post('/airline_list', [ApiController::class, 'airlineList'])->name('airline_list');
    Route::post('/availability', [ApiController::class, 'availability'])->name('availability');
    Route::post('/revalidate', [ApiController::class, 'revalidate'])->name('revalidate');
    Route::post('/fare_rules', [ApiController::class, 'fareRules'])->name('fare_rules');
    Route::post('/booking', [ApiController::class, 'booking'])->name('booking');

    Route::post('/ticket_order', [ApiController::class, 'ticketOrder'])->name('ticket_order');
    Route::post('/trip_details', [ApiController::class, 'tripDetails'])->name('trip_details');
    Route::post('/cancel', [ApiController::class, 'cancel'])->name('cancel');
    Route::post('/booking_notes', [ApiController::class, 'bookingNotes'])->name('booking_notes');
    Route::post('/void_ticket_quote', [ApiController::class, 'voidTicketQuote'])->name('void_ticket_quote');
    Route::post('/search_post_ticket_status', [ApiController::class, 'searchPostTicketStatus'])->name('search_post_ticket_status');
    Route::post('/void_ticket', [ApiController::class, 'voidTicket'])->name('void_ticket');

    Route::post('/refund_quote', [ApiController::class, 'refundQuote'])->name('refund_quote');
    Route::post('/refund', [ApiController::class, 'refund'])->name('refund');

    Route::post('/reissue_ticket_quote', [ApiController::class, 'reissueTicketQuote'])->name('reissue_ticket_quote');
    Route::post('/reissue_ticket', [ApiController::class, 'reissueTicket'])->name('reissue_ticket');
});