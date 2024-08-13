<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Generator;

use Exception;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\ModelGenerateRequest;
use Uzinfocom\Dastyor\Services\Generator;

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
