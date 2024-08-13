<?php

namespace Uzinfocom\Dastyor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Uzinfocom\Dastyor\Boot\Boot;
use Uzinfocom\Dastyor\Services\Utils\EntityFinderService;

class MethodWire extends GeneratorWire {

    public string $namespace;

    public array $meta = [
        'description' => "Kontrollerga method yaratuvchi",
        'route' => "methods.store"
    ];

    private readonly Collection $controllers;

    public function boot(EntityFinderService $modelFinder): void {
        $this->controllers = $this->getControllers($modelFinder);
    }

    public function render(): View {
        $controllers = $this->controllers;
        return view(Boot::getView('livewire.method-wire'), compact('controllers'));
    }
}
