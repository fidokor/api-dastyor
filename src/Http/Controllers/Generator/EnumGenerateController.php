<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Generator;

use Exception;
use Illuminate\Http\Request;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;
use Uzinfocom\LaravelGenerator\Http\Requests\GenerateEnumRequest;
use Uzinfocom\LaravelGenerator\Http\Requests\GenerateMethodRequest;
use Uzinfocom\LaravelGenerator\Services\Generator;

class EnumGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function __invoke(GenerateEnumRequest $request) {
        try {
            $this->generator->generateEnum($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
