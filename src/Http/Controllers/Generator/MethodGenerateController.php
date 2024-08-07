<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Generator;

use Exception;
use Illuminate\Http\Request;
use Uzinfocom\LaravelGenerator\Services\Generator;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;
use Uzinfocom\LaravelGenerator\Http\Requests\GeneratorRequest;

class MethodGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function __invoke(Request $request) {
        try {
            $this->generator->generateMethod($request->all());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
