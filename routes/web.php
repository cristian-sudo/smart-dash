<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Time Logs Routes
    Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');
    Route::post('/time-logs', [TimeLogController::class, 'store'])->name('time-logs.store');
    Route::get('/time-logs/calendar', [TimeLogController::class, 'calendar'])->name('time-logs.calendar');
    Route::post('/time-logs/generate-invoice', [TimeLogController::class, 'generateInvoice'])->name('time-logs.generate-invoice');

    // Services Routes
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});

require __DIR__.'/auth.php';
