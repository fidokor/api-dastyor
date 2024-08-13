<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Generator;

use Exception;
use Uzinfocom\Dastyor\Services\Generator;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\GenerateServiceRequest;

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
