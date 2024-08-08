<?php

namespace Uzinfocom\LaravelGenerator\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait StorageManager {

    const STUB_PATH = "stubs";

    public function getStub(): string {
        return File::get($this->root(self::STUB_PATH . "/$this->stab"));
    }

    public function getRelationStub($stub): string {
        return File::get($this->root(self::STUB_PATH . "/" . $stub));
    }

    public function resolvePath(?string $namespace): string {
        //        if ($namespace) {
        //            $path = join("\\", [$this->root, $namespace]);
        //        } else {
        //            $path = $this->root;
        //        }

        $path = Str::camel(Str::replace('\\', '/', $namespace));

        // Make a directory
        $directory = base_path($path);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, recursive: true);
        }

        return $path;
    }


    function root(string $path = ""): string {
        return __DIR__ . "/../../" . $path;
    }
}