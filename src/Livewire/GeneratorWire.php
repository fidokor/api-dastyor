<?php

namespace Ijodkor\LaravelGenerator\Livewire;

use Ijodkor\LaravelGenerator\Boot\Boot;
use Ijodkor\LaravelGenerator\Services\Utils\ModelFinderService;
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

    public function boot(ModelFinderService $modelFinder): void {
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

        $this->modelNamespace = $model->namespace;
    }

    public function change(): void {
        // Check for error
        $this->checkHasError();

        $this->namespace = $this->prefix . $this->package;
    }

    private function checkHasError(): void {
        $this->hasError = $this->namespace != preg_replace('#\\\\+#', '\\', $this->namespace);
    }

    private function getModels(ModelFinderService $modelFinder): Collection {
        return collect($modelFinder->getModels(app_path()))->map(function($model) {
            return (object)[
                'name' => Str::afterLast($model, "\\"),
                'namespace' => $model
            ];
        });
    }
}