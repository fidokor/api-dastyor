<?php

namespace Ijodkor\LaravelGenerator\Container;

interface IGenerator {

    function resolvePath(?string $namespace);
}