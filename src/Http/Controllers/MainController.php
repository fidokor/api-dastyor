<?php

namespace Uzinfocom\Dastyor\Http\Controllers;

use Illuminate\Contracts\View\View;
use Uzinfocom\Dastyor\Boot\Boot;

class MainController extends Controller {

    public function __invoke(): View {
        return view(Boot::getView('index'));
    }
}
