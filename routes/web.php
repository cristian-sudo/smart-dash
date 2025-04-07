<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->group(function () {
        // Time Logs Routes
        Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');
        Route::post('/time-logs', [TimeLogController::class, 'store'])->name('time-logs.store');
        Route::get('/time-logs/calendar', [TimeLogController::class, 'calendar'])->name('time-logs.calendar');
        Route::post('/time-logs/generate-invoice', [TimeLogController::class, 'generateInvoice'])->name('time-logs.generate-invoice');
        Route::get('/time-logs/preview-invoice', [TimeLogController::class, 'previewInvoice'])->name('time-logs.preview-invoice');
        Route::delete('/time-logs/{timeLog}', [TimeLogController::class, 'destroy'])->name('time-logs.destroy');

        // Invoices Routes
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/preview', [InvoiceController::class, 'preview'])->name('invoices.preview');
        Route::get('/invoices/download', [InvoiceController::class, 'download'])->name('invoices.download');

        // Services Routes
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/invoice', [InvoiceController::class, 'preview'])->name('invoice.preview');
    Route::get('/dashboard/invoice/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/dashboard/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/dashboard/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::put('/dashboard/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/dashboard/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::get('/dashboard/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/dashboard/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/dashboard/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/dashboard/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::get('/dashboard/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');
    Route::get('/dashboard/time-logs/{timeLog}', [TimeLogController::class, 'show'])->name('time-logs.show');
    Route::post('/dashboard/time-logs', [TimeLogController::class, 'store'])->name('time-logs.store');
    Route::put('/dashboard/time-logs/{timeLog}', [TimeLogController::class, 'update'])->name('time-logs.update');
    Route::delete('/dashboard/time-logs/{timeLog}', [TimeLogController::class, 'destroy'])->name('time-logs.destroy');
    Route::get('/dashboard/time-logs/{timeLog}/duplicate', [TimeLogController::class, 'duplicate'])->name('time-logs.duplicate');
});

require __DIR__.'/auth.php';
