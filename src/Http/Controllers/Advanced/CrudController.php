<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Advanced;

use Exception;
use Uzinfocom\LaravelGenerator\Http\Requests\CrudRequest;
use Uzinfocom\LaravelGenerator\Services\Generator;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;
use Uzinfocom\LaravelGenerator\Http\Requests\GeneratorRequest;

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
