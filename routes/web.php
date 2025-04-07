<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->group(function () {
        // Time Logs Route
        Route::get('/time-logs', function () {
            return view('dashboard.time-logs');
        })->name('time-logs.index');

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
});

require __DIR__.'/auth.php';
