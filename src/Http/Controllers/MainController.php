<?php

namespace Ijodkor\LaravelGenerator\Http\Controllers;

use Illuminate\Contracts\View\View;

class MainController extends Controller {

    public function __invoke(): View {
        return view('generator::index');
    }
}
