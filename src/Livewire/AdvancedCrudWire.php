<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

use Illuminate\Contracts\View\View;
use Uzinfocom\LaravelGenerator\Boot\Boot;

class AdvancedCrudWire extends GeneratorWire {

    // Props
    public array $meta = [
        'description' => "Kontroller yaratuvchi",
        'route' => "advanced.crud.store"
    ];

    protected string $view = "livewire.advanced-crud";

//    public string $prefix = "App\Http\Controllers\\";
//    public string $suffix = "Controller";
//    public string $namespace = "App\Http\Controllers";

    public string $modelNamespace;
    public string $modelName;


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
            return $model->namespace == $this->modelNamespace;
        })->first();

        $path = $model ? ($model->folder ? $model->folder . $model->name : $model->name) : '';
        $this->modelNamespace = $model?->namespace ?? "";

        $this->controllerName = $path;
        $this->createRequestName = $path;
        $this->updateRequestName = $path;
    }

}
