<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

class ControllerWire extends GeneratorWire {

    // Props
    public array $meta = [
        'description' => "Kontroller yaratuvchi",
        'route' => "controllers.store"
    ];

    public string $prefix = "App\Http\Controllers\\";
    public string $namespace = "App\Http\Controllers";
    protected string $view = "livewire.controller";
}
