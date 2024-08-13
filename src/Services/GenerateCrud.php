<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenerateCrud extends AllGenerator {

    public function __construct() {
        $this->stab = 'advanced-controller.stub';
        $this->group = ".php";
    }

    public function generate(array $form): void {
        $stub = $this->getStub();
        $modelName = Str::afterLast($form['model'], '\\');
        $modelInfo = ['name' => $modelName, 'namespace' => $form['model']];
        $namespace = Str::beforeLast(($form['controllerPrefix'] . $form['controllerName']), '\\');
        $controllerName = Str::afterLast($form['controllerName'], '\\') . $form['controllerSuffix'];

        $this->requestCreateGenerate($form, $modelInfo, $stub);
        $this->requestUpdateGenerate($form, $modelInfo, $stub);
        $this->serviceGenerate($form, $modelInfo, $stub);
        $this->resourceGenerate($form, $modelInfo, $stub);

        $modelNameSingular = Str::lcfirst($modelName);
        $modelNamePlural = Str::plural($modelNameSingular);
        $modelResourceName = Str::kebab($modelNamePlural);

        /* @var Model $entity */
        // Read boilerplate from storage

        $stub = str_replace([
            '{{ namespace }}',
            '{{ controllerName }}',
            '{{ modelName }}',
            '{{ modelNamePlural }}',
            '{{ modelNameSingular }}',
            '{{ modelResourceName }}'
        ], [
            $namespace,
            $controllerName,
            $modelName,
            $modelNamePlural,
            $modelNameSingular,
            $modelResourceName
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$controllerName
        $this->make($location, $controllerName, $stub);
    }

    private function serviceGenerate(array $form, array $modelInfo, &$stub): void {
        $serviceName = Str::afterLast($form['serviceName'], '\\') . $form['serviceSuffix'];
        $useService = Str::beforeLast($form['serviceName'], '\\') . '\\' . $serviceName;

        $stub = str_replace([
            '{{ serviceName }}',
            '{{ useService }}'
        ], [
            $serviceName,
            $useService
        ], $stub);

        $generator = new ServiceGenerator();
        $generator->generate(
            $modelInfo,
            Str::afterLast($form['serviceName'], '\\'),
            $form['servicePrefix'] . Str::beforeLast($form['serviceName'], '\\')
        );
    }

    private function resourceGenerate(array $form, array $modelInfo, &$stub): void {
        $resourceName = Str::afterLast($form['resourceName'], '\\') . $form['resourceSuffix'];
        $useResource = Str::beforeLast($form['resourceName'], '\\') . '\\' . $resourceName;

        $stub = str_replace([
            '{{ resourceName }}',
            '{{ useResource }}'
        ], [
            $resourceName,
            $useResource
        ], $stub);

        $generator = new GenerateResource();
        $generator->generate(
            $modelInfo,
            Str::afterLast($form['resourceName'], '\\'),
            $form['resourcePrefix'] . Str::beforeLast($form['resourceName'], '\\')
        );
    }

    private function requestCreateGenerate(array $form, array $modelInfo, &$stub): void {
        $createRequest = Str::afterLast($form['createRequestName'], '\\') . $form['createRequestSuffix'];
        $useCreateRequest = Str::beforeLast($form['createRequestName'], '\\') . '\\' . $createRequest;

        $stub = str_replace([
            '{{ createRequest }}',
            '{{ useCreateRequest }}'
        ], [
            $createRequest,
            $useCreateRequest
        ], $stub);

        $generator = new GenerateRequest();
        $generator->generateCreate(
            $modelInfo,
            Str::afterLast($form['createRequestName'], '\\'),
            $form['createRequestPrefix'] . Str::beforeLast($form['createRequestName'], '\\')
        );
    }

    private function requestUpdateGenerate(array $form, array $modelInfo, &$stub): void {
        $updateRequest = Str::afterLast($form['updateRequestName'], '\\') . $form['updateRequestSuffix'];
        $useUpdateRequest = Str::beforeLast($form['updateRequestName'], '\\') . '\\' . $updateRequest;

        $stub = str_replace([
            '{{ updateRequest }}',
            '{{ useUpdateRequest }}'
        ], [
            $updateRequest,
            $useUpdateRequest,
        ], $stub);

        $generator = new GenerateRequest();
        $generator->generateUpdate(
            $modelInfo,
            Str::afterLast($form['updateRequestName'], '\\'),
            $form['updateRequestPrefix'] . Str::beforeLast($form['updateRequestName'], '\\')
        );
    }
}
