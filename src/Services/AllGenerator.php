<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Uzinfocom\LaravelGenerator\Helpers\StorageManager;
use Illuminate\Support\Facades\File;

class AllGenerator {
    use StorageManager;

    protected string $stab;
    protected string $group;

    protected function make(string $location, string $name, string $content): void {
        $path = base_path(join("/", [$location, $name . $this->group]));
        File::put($path, $content);
    }

    protected function overwrite(string $location, string $content): void {
//        dd($location, $name, $content);
        $path = base_path(join("/", [$location . $this->group]));
//        dd($path);
        File::put($path, $content);
    }
}