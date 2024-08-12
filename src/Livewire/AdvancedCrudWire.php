<?php

namespace Uzinfocom\LaravelGenerator\Livewire;


class AdvancedCrudWire extends GeneratorWire {

    // Props
    public array $meta = [
        'description' => "Crud yaratuvchi",
        'route' => "advanced.crud.store"
    ];

    protected string $view = "livewire.advanced-crud";
    public string $model;

    /*** controller ***/

    public string $baseController = "App\Http\Controllers\Controller";


    public string $controllerPrefix = "App\Http\Controllers\\";
    public string $controllerName = "";
    public string $controllerSuffix = "Controller";

    /*** create request ***/
    public string $createRequestPrefix = "App\Http\Request\\";
    public string $createRequestName = "";
    public string $createRequestSuffix = "Request";

    /*** update request ***/
    public string $updateRequestPrefix = "App\Http\Request\\";
    public string $updateRequestName = "";
    public string $updateRequestSuffix = "Request";


    public function modelChoose(): void {
        $model = $this->models->filter(function($model) {
            return $model->namespace == $this->model;
        })->first();

        $path = $model ? ($model->folder ? $model->folder . $model->name : $model->name) : '';

        $this->controllerName = $path;
        $this->createRequestName = $path;
        $this->updateRequestName = $path;
    }

}
