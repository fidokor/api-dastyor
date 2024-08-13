<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Generator;

use Exception;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\GenerateMethodRequest;
use Uzinfocom\Dastyor\Services\Generator;

class MethodGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function __invoke(GenerateMethodRequest $request) {
        try {
            $this->generator->generateMethod($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
