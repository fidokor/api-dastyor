<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Advanced;

use Exception;
use Uzinfocom\Dastyor\Http\Requests\CrudRequest;
use Uzinfocom\Dastyor\Services\Generator;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\GeneratorRequest;

class CrudController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function create() {
        return view('generator::advanced.crud.create');
    }

    public function store(CrudRequest $request) {
        try {
            $this->generator->generateCrud($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }


}
