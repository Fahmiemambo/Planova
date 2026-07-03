<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlockController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Tasks
    Route::resource('tasks', TaskController::class);

    // Finance
    Route::resource('finance', FinanceController::class);

    // Budget
    Route::resource('budget', BudgetController::class);

    // Documents
    Route::resource('documents', DocumentController::class);

    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
        ->name('documents.download');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

    // Blocks
    Route::prefix('blocks')->name('blocks.')->group(function () {

        Route::post('/', [BlockController::class, 'store'])
            ->name('store');

        Route::put('/{block}', [BlockController::class, 'update'])
            ->name('update');

        Route::delete('/{block}', [BlockController::class, 'destroy'])
            ->name('destroy');

        Route::post('/reorder', [BlockController::class, 'reorder'])
            ->name('reorder');

    });

});