<?php

namespace Ijodkor\LaravelGenerator\Services;

use Illuminate\Database\Eloquent\Model;

class GenerateController extends AllGenerator {

    public function __construct() {
        $this->stab = 'controller.stub';
        $this->group = "Controller.php";
    }

    public function generate(array $model, string $name, string $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        // Model
        $modelName = $model['name'];

        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ modelName }}',
        ], [
            $namespace,
            $name,
            $modelName,
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }
}
