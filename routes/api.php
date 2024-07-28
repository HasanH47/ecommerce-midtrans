<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.notification');
