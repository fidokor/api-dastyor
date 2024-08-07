<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers;

use Illuminate\Contracts\View\View;
use Uzinfocom\LaravelGenerator\Boot\Boot;

class MainController extends Controller {

    public function __invoke(): View {
        return view(Boot::getView('index'));
    }
}
