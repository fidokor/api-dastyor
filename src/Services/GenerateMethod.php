<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenerateMethod extends AllGenerator {

    public function __construct() {
        $this->stab = 'controller.stub';
        $this->group = "Controller.php";
    }

    public function generate(string $namespace, string $controller, string $name): void {
        /* @var Model $entity */
        // Read boilerplate from storage


        dd($namespace, $controller, $name);
    }
}
