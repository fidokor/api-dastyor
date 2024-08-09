<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenerateCrud extends AllGenerator {

    public function __construct() {
        $this->stab = 'advanced-controller.stub';
        $this->group = "Controller.php";
    }

    public function generate($modelName, $name, $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        $path = $namespace . '\\' . $name;
        $name = Str::afterLast($name, '\\');
        $namespace = Str::beforeLast($path, '\\');
        $controllerNamespace = '';
        if ($namespace != 'App\Http\Controllers\\') {
            $controllerNamespace = 'App\Http\Controllers\Controller';
        }
        // need add check file is exist

        // Model
        // $modelName = $model['name'];
        $modelNamePlural = Str::plural(Str::lcfirst($modelName));
        $modelNameSingular = Str::lcfirst($modelName);
        $modelResourceName = Str::lower(preg_replace('/([a-z])([A-Z])/', '$1-$2', Str::plural($modelName)));

        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ modelName }}',
            '{{ modelNamePlural }}',
            '{{ modelNameSingular }}',
            '{{ modelResourceName }}',
        ], [
            $namespace,
            $name,
            $modelName,
            $modelNamePlural,
            $modelNameSingular,
            $modelResourceName,
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }
}
