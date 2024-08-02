<?php

namespace Ijodkor\LaravelGenerator\Http\Controllers\Generator;

use Exception;
use Ijodkor\LaravelGenerator\Http\Controllers\Controller;
use Ijodkor\LaravelGenerator\Http\Requests\ModelGenerateRequest;
use Ijodkor\LaravelGenerator\Services\Generator;

class ModelGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) { }

    public function __invoke(ModelGenerateRequest $request) {
        try {
            $this->generator->generateModel($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
