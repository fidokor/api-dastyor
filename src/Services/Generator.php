<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Illuminate\Support\Arr;

readonly class Generator {
    public function __construct(
        private GenerateModel              $generateModel,
        private ServiceGenerator           $service,
        private GenerateResource           $resource,
        private GenerateRequest            $request,
        private GenerateController         $controller,
        private GenerateCrud               $crud,
        private GenerateMethod             $method,
        private GenerateRoute              $generateRoute,
    ) {
    }

    public function generate($data): void {
        $tableName = Arr::get($data, 'table_name');

        /** Model class **/
        $modelName = Arr::get($data, 'model_name');
        $modelNamespace = Arr::get($data, 'model_namespace');
        $this->generateModel->generate($tableName, $modelName, $modelNamespace);

        /** Service class **/
        $serviceName = Arr::get($data, 'service_name');
        $serviceNamespace = Arr::get($data, 'service_namespace');
        $this->service->generate($serviceName, $serviceNamespace, "");

        /** Resource class **/
        $resourceName = Arr::get($data, 'resource_name');
        $resourceNamespace = Arr::get($data, 'resource_namespace');
        $this->resource->generate($tableName, $resourceName, $resourceNamespace);

        /** Request class **/
        $requestName = Arr::get($data, 'request_name');
        $requestNamespace = Arr::get($data, 'request_namespace');
        /** Request create **/
        $this->request->generateCreate($tableName, $requestName, $requestNamespace);
        /** Request update **/
        $this->request->generateUpdate($tableName, $requestName, $requestNamespace);

        /** Controller class **/
        $controllerName = Arr::get($data, 'controller_name');
        $controllerNamespace = Arr::get($data, 'controller_namespace');
        $this->controller->generate($controllerName, $controllerNamespace);

        /** Route **/
        $this->generateRoute->generate($tableName, $modelName);
    }

    public function generateModel($data): void {
        $table = Arr::get($data, 'table');

        /** Model class **/
        $name = Arr::get($data, 'name');
        $namespace = Arr::get($data, 'namespace');
        $this->generateModel->generate($table, $name, $namespace);
    }

    /**
     * @description Service class
     */
    public function generateService(array $data): void {
        $model = Arr::get($data, 'model');
        $name = Arr::get($data, 'name');
        $namespace = Arr::get($data, 'namespace', "");

        $this->service->generate($model, $name, $namespace);
    }

    public function generateRequest(array $data): void {
        $model = Arr::get($data, 'model');

        /** Request class **/
        $name = Arr::get($data, 'name');
        $namespace = Arr::get($data, 'namespace');

        /** Request create **/
        $this->request->generateCreate($model, $name, $namespace);
        /** Request update **/
        $this->request->generateUpdate($model, $name, $namespace);
    }

    public function generateResource(array $attributes): void {
        $model = Arr::get($attributes, 'model');

        /** Resource class **/
        $name = Arr::get($attributes, 'name');
        $namespace = Arr::get($attributes, 'namespace');

        $this->resource->generate($model, $name, $namespace);
    }

    public function generateController(array $attributes): void {
        /** Controller class **/
        $model = Arr::get($attributes, 'model');
        $name = Arr::get($attributes, 'name');
        $namespace = Arr::get($attributes, 'namespace');

        $this->controller->generate($model, $name, $namespace);
    }

    public function generateCrud(array $attributes): void {
        /** Crud **/

        $baseController = Arr::get($attributes, 'model.name');

        $controllerPrefix = Arr::get($attributes, 'controller.prefix');
        $controllerName = Arr::get($attributes, 'controller.name');
        $controllerSuffix = Arr::get($attributes, 'controller.suffix');

        $createRequestPrefix = Arr::get($attributes, 'request.create.prefix');
        $createRequestName = Arr::get($attributes, 'request.create.name');
        $createRequestSuffix = Arr::get($attributes, 'request.create.suffix');

        $updateRequestPrefix = Arr::get($attributes, 'request.update.prefix');
        $updateRequestName = Arr::get($attributes, 'request.update.name');
        $updateRequestSuffix = Arr::get($attributes, 'request.update.suffix');

        $modelName = Arr::get($attributes, 'model.name');
        $model = Arr::get($attributes, 'model');
        $controller = Arr::get($attributes, 'controller');
        $name = Arr::get($controller, 'name');
        $namespace = Arr::get($controller, 'namespace');

        $this->crud->generate($model, $name, $namespace);
    }

    public function generateMethod(array $attributes): void {
        /** Controller class **/
        $controller = Arr::get($attributes, 'controller');
        $name = Arr::get($attributes, 'name');
        $namespace = Arr::get($attributes, 'namespace');

        $this->method->generate($namespace, $controller, $name);
    }
}
