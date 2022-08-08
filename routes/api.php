<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TerminalController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserTicketsController;
use App\Http\Controllers\Api\TicketPaymentsController;
use App\Http\Controllers\Api\TicketTerminalsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Tickets
        Route::get('/users/{user}/tickets', [
            UserTicketsController::class,
            'index',
        ])->name('users.tickets.index');
        Route::post('/users/{user}/tickets', [
            UserTicketsController::class,
            'store',
        ])->name('users.tickets.store');

        Route::apiResource('tickets', TicketController::class);

        // Ticket Terminals
        Route::get('/tickets/{ticket}/terminals', [
            TicketTerminalsController::class,
            'index',
        ])->name('tickets.terminals.index');
        Route::post('/tickets/{ticket}/terminals', [
            TicketTerminalsController::class,
            'store',
        ])->name('tickets.terminals.store');

        // Ticket Payments
        Route::get('/tickets/{ticket}/payments', [
            TicketPaymentsController::class,
            'index',
        ])->name('tickets.payments.index');
        Route::post('/tickets/{ticket}/payments', [
            TicketPaymentsController::class,
            'store',
        ])->name('tickets.payments.store');

        Route::apiResource('payments', PaymentController::class);

        Route::apiResource('terminals', TerminalController::class);
    });
