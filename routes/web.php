<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TimeLogController;
use App\Livewire\Invoices;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Invoice;
use App\Livewire\Services;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');

    Route::prefix('dashboard')->group(function () {
        // Time Logs Route
        Route::get('/time-logs', function () {
            return view('dashboard.time-logs');
        })->name('time-logs.index');

        // Invoices Route
        Route::get('/invoices', Invoices::class)->name('invoices.index');
        Route::get('/invoices/{invoice}/download', [Invoices::class, 'download'])->name('invoices.download');

        // Services Routes
        Route::get('/services', Services::class)->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

        // Clients Route
        Route::get('/clients', function () {
            return view('dashboard.clients');
        })->name('clients.index');

        // Companies Route
        Route::get('/companies', function () {
            return view('dashboard.companies');
        })->name('companies.index');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
