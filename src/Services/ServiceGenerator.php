<?php

namespace Ijodkor\LaravelGenerator\Services;

use Ijodkor\LaravelGenerator\Container\IGenerator;

class ServiceGenerator extends AllGenerator implements IGenerator {
    public function __construct() {
        $this->stab = 'service.stub';
        $this->group = "Service.php";
    }

    public function generate(array $model, string $name, ?string $namespace): void {
        // Read boilerplate from storage
        $boilerplate = $this->getStub();

        // Model
        $modelName = $model['name'];
        $modelNamespace = $model['namespace'];

        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ modelNamespace }}',
            '{{ modelName }}'
        ], [
            $namespace,
            $name,
            $modelNamespace,
            $modelName,
        ], $boilerplate);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }
}
