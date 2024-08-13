<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Builders;

use Illuminate\Contracts\View\View;
use Uzinfocom\Dastyor\Boot\Boot;
use Uzinfocom\Dastyor\Http\Controllers\Controller;

class MigrationBuilderController extends Controller {
    public function __invoke(): View {
        return view(Boot::getView('migration.index'));
    }
}
