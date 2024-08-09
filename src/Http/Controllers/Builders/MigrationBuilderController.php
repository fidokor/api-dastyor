<?php

namespace Uzinfocom\LaravelGenerator\Http\Controllers\Builders;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Uzinfocom\LaravelGenerator\Boot\Boot;
use Uzinfocom\LaravelGenerator\Http\Controllers\Controller;
use Uzinfocom\LaravelGenerator\Http\Requests\MigrationMakeRequest;
use Uzinfocom\LaravelGenerator\Services\Migration\MigrationBuildService;

class MigrationBuilderController extends Controller {

    public function __construct(private readonly MigrationBuildService $service) {

    }

    public function __invoke(): View {
        return view(Boot::getView('migration.index'));
    }

    public function store(MigrationMakeRequest $request): RedirectResponse {
        try {
            $this->service->create($request->validated());

            return redirect()->back();
        } catch (Exception $ex) {
            dd($ex);
        }
    }
}
