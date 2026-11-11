<?php

use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ResearchController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('projects', ProjectController::class)->except('show');
        Route::resource('researches', ResearchController::class)->except('show');
        Route::resource('skills', SkillController::class)->except('show');
        Route::resource('certificates', CertificateController::class)->except('show');

        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::patch('/messages/{message}/read', [MessageController::class, 'markRead'])->name('messages.read');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
