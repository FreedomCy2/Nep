<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AuthController;


// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/admin/register', function () {
    return view('admin.register');
})->name('admin.register');

Route::get('/user/login', function () {
    return view('user.login');
})->name('user.login');

Route::get('/user/register', function () {
    return view('user.register');
})->name('user.register');

Route::get('/user/introduction', function () {
    return view('user.introduction');
})->name('user.introduction');


// Custom Registration Routes (Keep this version)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Custom Login Route
Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login');

// Dashboard Views
Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated User Settings (Volt Components)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    
    // Optional routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
});
// Auth scaffolding (e.g. login, logout, etc.)
require __DIR__.'/auth.php';
