<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Generator;

use Exception;
use Illuminate\Http\Request;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\GenerateEnumRequest;
use Uzinfocom\Dastyor\Http\Requests\GenerateMethodRequest;
use Uzinfocom\Dastyor\Services\Generator;

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
