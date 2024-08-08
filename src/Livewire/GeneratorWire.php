<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

use Uzinfocom\LaravelGenerator\Boot\Boot;
use Uzinfocom\LaravelGenerator\Services\Utils\EntityFinderService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class GeneratorWire extends Component {

    // Props
    public array $meta = [
        'description' => "Servis yaratuvchi",
        'route' => "services.store"
    ];
    private string $view = "livewire.generator";

    public string $modelNamespace = "";
    public string $modelName = "";

    public string $package = "";
    public string $prefix = "App\Services\\";
    public string $namespace = "App\Services";

    public bool $hasError = false;

    private readonly Collection $models;

    public function boot(EntityFinderService $modelFinder): void {
        $this->models = $this->getModels($modelFinder);
    }

    public function render(): View {
        $models = $this->models;
        return view(Boot::getView($this->view), compact('models'));
    }

    public function choose(): void {
        $model = $this->models->filter(function($m) {
            return $m->name == $this->modelName;
        })->first();

        $this->modelNamespace = $model?->namespace ?? "";
    }

    public function change(): void {
        // Check for error
        $this->checkHasError();

        $this->namespace = $this->prefix . $this->package;
    }

    private function checkHasError(): void {
        $this->hasError = $this->namespace != preg_replace('#\\\\+#', '\\', $this->namespace);
    }

    private function getModels(EntityFinderService $modelFinder): Collection {
        return collect($modelFinder->getModels(app_path()))->map(function($model) {
            return (object)[
                'name' => Str::afterLast($model, "\\"),
                'namespace' => $model
            ];
        });
    }

    public function getControllers(EntityFinderService $controllerFinder): Collection {
        return collect($controllerFinder->getControllers(app_path()))->map(function($controller) {
            return (object)[
                'name' => Str::afterLast($controller, "\\"),
                'namespace' => $controller
            ];
        });
    }
}