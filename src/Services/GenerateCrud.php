<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GenerateCrud extends AllGenerator {

    public function __construct() {
        $this->stab = 'advanced-controller.stub';
        $this->group = ".php";
    }

    public function generate(array $form): void {
        $modelName = Str::afterLast($form['model'], '\\');
        $modelInfo = ['name' => $modelName,'namespace' => $form['model']];
        $namespace = Str::beforeLast(($form['controllerPrefix'] . $form['controllerName']), '\\');
        $controllerName = Str::afterLast($form['controllerName'], '\\') . $form['controllerSuffix'];

        // create request
        $createRequest = Str::afterLast($form['createRequestName'], '\\') . $form['createRequestSuffix'];
        $useCreateRequest = Str::beforeLast($form['createRequestName'], '\\') . '\\' . $createRequest;
        $this->requestCreateGenerate($form, $modelInfo);

        // update request
        $updateRequest = Str::afterLast($form['updateRequestName'], '\\') . $form['updateRequestSuffix'];
        $useUpdateRequest = Str::beforeLast($form['updateRequestName'], '\\') . '\\' . $updateRequest;
        $this->requestUpdateGenerate($form, $modelInfo);

        // service
        $serviceName = Str::afterLast($form['serviceName'], '\\') . $form['serviceSuffix'];
        $useService = Str::beforeLast($form['serviceName'], '\\') . '\\' . $serviceName;
        $this->serviceGenerate($form, $modelInfo);

        // resource
        $resourceName = Str::afterLast($form['resourceName'], '\\') . $form['resourceSuffix'];
        $useResource = Str::beforeLast($form['resourceName'], '\\') . '\\' . $resourceName;
        $this->resourceGenerate($form, $modelInfo);

        $modelNameSingular = Str::lcfirst($modelName);
        $modelNamePlural = Str::plural($modelNameSingular);
        $modelResourceName = Str::kebab($modelNamePlural);

        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        $content = str_replace([
            '{{ namespace }}',
            '{{ controllerName }}',
            '{{ modelName }}',
            '{{ modelNamePlural }}',
            '{{ modelNameSingular }}',
            '{{ modelResourceName }}',
            '{{ createRequest }}',
            '{{ useCreateRequest }}',
            '{{ updateRequest }}',
            '{{ useUpdateRequest }}',
            '{{ serviceName }}',
            '{{ useService }}',
            '{{ resourceName }}',
            '{{ useResource }}'
        ], [
            $namespace,
            $controllerName,
            $modelName,
            $modelNamePlural,
            $modelNameSingular,
            $modelResourceName,
            $createRequest,
            $useCreateRequest,
            $updateRequest,
            $useUpdateRequest,
            $serviceName,
            $useService,
            $resourceName,
            $useResource
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$controllerName
        $this->make($location, $controllerName, $content);
    }

    private function serviceGenerate(array $form, array $modelInfo): void {
        $generator = new ServiceGenerator();
        $generator->generate(
            $modelInfo,
            Str::afterLast($form['serviceName'], '\\'),
            $form['servicePrefix'] . Str::beforeLast($form['serviceName'], '\\')
        );
    }

    private function resourceGenerate(array $form, array $modelInfo): void {
        $generator = new GenerateResource();
        $generator->generate(
            $modelInfo,
            Str::afterLast($form['resourceName'], '\\'),
            $form['resourcePrefix'] . Str::beforeLast($form['resourceName'], '\\')
        );
    }

    private function requestCreateGenerate(array $form, array $modelInfo): void {
        $generator = new GenerateRequest();
        $generator->generateCreate(
            $modelInfo,
            Str::afterLast($form['createRequestName'], '\\'),
            $form['createRequestPrefix'] . Str::beforeLast($form['createRequestName'], '\\')
        );
    }

    private function requestUpdateGenerate(array $form, array $modelInfo): void {
        $generator = new GenerateRequest();
        $generator->generateUpdate(
            $modelInfo,
            Str::afterLast($form['updateRequestName'], '\\'),
            $form['updateRequestPrefix'] . Str::beforeLast($form['updateRequestName'], '\\')
        );
    }
}
