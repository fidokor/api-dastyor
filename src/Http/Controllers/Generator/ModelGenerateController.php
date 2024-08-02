<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Generator;

use Exception;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;
use Uzinfocom\LaravelGenerator\Http\Requests\ModelGenerateRequest;
use Uzinfocom\LaravelGenerator\Services\Generator;

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
