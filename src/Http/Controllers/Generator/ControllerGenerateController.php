<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Generator;

use Exception;
use Uzinfocom\Dastyor\Services\Generator;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\GeneratorRequest;

class ControllerGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function __invoke(GeneratorRequest $request) {
        try {
            $this->generator->generateController($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
