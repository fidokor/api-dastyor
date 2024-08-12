<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Builders;

use Illuminate\Contracts\View\View;
use Uzinfocom\LaravelGenerator\Boot\Boot;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;

class MigrationBuilderController extends Controller {
    public function __invoke(): View {
        return view(Boot::getView('migration.index'));
    }
}
