<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\FaqAdminController;
use Modules\Faq\Http\Controllers\FaqController;

Route::prefix('admin/faq')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [FaqAdminController::class, 'index'])->name('admin.faq.index');
    Route::get('/create', [FaqAdminController::class, 'create'])->name('admin.faq.create');
    Route::post('/', [FaqAdminController::class, 'store'])->name('admin.faq.store');
    Route::get('/{item}/edit', [FaqAdminController::class, 'edit'])->name('admin.faq.edit');
    Route::put('/{item}', [FaqAdminController::class, 'update'])->name('admin.faq.update');
    Route::delete('/{item}', [FaqAdminController::class, 'destroy'])->name('admin.faq.destroy');


    Route::get('/categories', [FaqAdminController::class, 'categories'])->name('admin.faq.categories');
    Route::post('/categories', [FaqAdminController::class, 'storeCategory'])->name('admin.faq.categories.store');
    Route::put('/categories/{category}', [FaqAdminController::class, 'updateCategory'])->name('admin.faq.categories.update');
    Route::delete('/categories/{category}', [FaqAdminController::class, 'destroyCategory'])->name('admin.faq.categories.destroy');
});

Route::prefix('faq')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/{category:slug?}', [FaqController::class, 'category'])->name('faq.index');
});
