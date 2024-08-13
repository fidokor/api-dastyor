<?php

use Uzinfocom\Dastyor\Http\Controllers\Advanced\CrudController;
use Uzinfocom\Dastyor\Http\Controllers\Builders\MigrationBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\ControllerGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\EnumGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\MethodGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\ModelGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\RequestGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\ResourceGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\Generator\ServiceGenerateController;
use Uzinfocom\Dastyor\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)->name('generator.index');

Route::prefix('/advanced')->as('advanced.')->group(function() {
    Route::get('crud', [CrudController::class, 'create'])->name('crud');
    Route::post('crud', [CrudController::class, 'store'])->name('crud.store');
});

Route::prefix('/generate')->group(function() {
    Route::post('models', ModelGenerateController::class)->name('models.store');
    Route::post('services', ServiceGenerateController::class)->name('service.store');
    Route::post('requests', RequestGenerateController::class)->name('requests.store');
    Route::post('resources', ResourceGenerateController::class)->name('resources.store');
    Route::post('controllers', ControllerGenerateController::class)->name('controllers.store');
    Route::post('methods', MethodGenerateController::class)->name('methods.store');
    Route::post('enums', EnumGenerateController::class)->name('enums.store');
});

// Add extra
Route::get('/migration', MigrationBuilderController::class)->name('migration.builder');

// Catch-all Route...
//Route::get('/{view?}', GeneratorController::class)->where('view', '(.*)')->name('generator.index');