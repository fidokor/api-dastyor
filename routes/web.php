<?php

use Ijodkor\LaravelGenerator\Http\Controllers\Generator\ControllerGenerateController;
use Ijodkor\LaravelGenerator\Http\Controllers\Generator\ModelGenerateController;
use Ijodkor\LaravelGenerator\Http\Controllers\Generator\RequestGenerateController;
use Ijodkor\LaravelGenerator\Http\Controllers\Generator\ResourceGenerateController;
use Ijodkor\LaravelGenerator\Http\Controllers\Generator\ServiceGenerateController;
use Ijodkor\LaravelGenerator\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)->name('generator.index');

Route::prefix('/generate')->group(function() {
    Route::post('models', ModelGenerateController::class)->name('models.store');
    Route::post('services', ServiceGenerateController::class)->name('service.store');
    Route::post('requests', RequestGenerateController::class)->name('requests.store');
    Route::post('resources', ResourceGenerateController::class)->name('resources.store');
    Route::post('controllers', ControllerGenerateController::class)->name('controllers.store');
});

// Catch-all Route...
//Route::get('/{view?}', GeneratorController::class)->where('view', '(.*)')->name('generator.index');