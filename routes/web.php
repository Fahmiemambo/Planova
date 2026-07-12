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
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TaskPropertyController;
use App\Http\Controllers\NoteController;

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

    Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

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
    return view('landing');
});

// Support page (developer QRIS)
Route::get('/support', function () {
    return view('support.index');
})->name('support');

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

    // Notes
    Route::resource('notes', NoteController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    // Task status quick-update (no title required)
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Finance
    Route::resource('finance', FinanceController::class);

    // Economy News
    Route::get('/economy-news', [App\Http\Controllers\EconomyNewsController::class, 'index'])
        ->name('economy-news.index');

    // Documents
    Route::resource('documents', DocumentController::class);

    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])
        ->name('documents.preview');

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

    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])
        ->name('profile.avatar.upload');

    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])
        ->name('profile.avatar.delete');

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

    // Task Properties (definitions + per-task values)
    Route::prefix('task-properties')->name('task-properties.')->group(function () {

        Route::get('/', [TaskPropertyController::class, 'index'])
            ->name('index');

        Route::post('/', [TaskPropertyController::class, 'store'])
            ->name('store');

        Route::put('/{property}', [TaskPropertyController::class, 'update'])
            ->name('update');

        Route::delete('/{property}', [TaskPropertyController::class, 'destroy'])
            ->name('destroy');

        Route::post('/reorder', [TaskPropertyController::class, 'reorder'])
            ->name('reorder');

        // Per-task values
        Route::post('/{property}/values', [TaskPropertyController::class, 'setValue'])
            ->name('values.set');

        Route::delete('/{property}/values/{taskId}', [TaskPropertyController::class, 'clearValue'])
            ->name('values.clear');

    });

});