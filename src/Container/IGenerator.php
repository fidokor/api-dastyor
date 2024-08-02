<?php

namespace Uzinfocom\LaravelGenerator\Container;

interface IGenerator {

    function resolvePath(?string $namespace);
}