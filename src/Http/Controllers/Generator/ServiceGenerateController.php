<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Generator;

use Exception;
use Uzinfocom\LaravelGenerator\Services\Generator;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;
use Uzinfocom\LaravelGenerator\Http\Requests\GenerateServiceRequest;

class ServiceGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function __invoke(GenerateServiceRequest $request) {
        try {
            $this->generator->generateService($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back()->with('errors');
        }
    }
}
