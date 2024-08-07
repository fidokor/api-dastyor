<?php

namespace Uzinfocom\LaravelGenerator\Services\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;
use SplFileInfo;

class ModelFinderService {
    public const NECESSARY_FILE = "php";
    public const APP = "App\\";

    function scan(string $directory): array {
        /**
         * @var SplFileInfo $file
         */
        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if ($file->getExtension() === self::NECESSARY_FILE) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * Retrieve models
     */
    function getModels(string $directory): array {
        $models = [];
        $files = $this->scan($directory);

        // Require all file that php can identify as file
        foreach ($files as $file) {
            require_once $file;
        }

        $classes = get_declared_classes();
        foreach ($classes as $class) {
            $isSubClass = is_subclass_of($class, Model::class);
            try {
                $isAbstract = (new ReflectionClass($class))->isAbstract();

                if ($isSubClass && !$isAbstract && Str::startsWith($class, self::APP)) {
                    $models[] = $class;
                }
            } catch (ReflectionException) {

            }
        }

        return array_unique($models);
    }

    function getControllers(string $directory): array {
        $controllers = [];
        $files = $this->scan($directory);

        // Require all file that php can identify as file
        foreach ($files as $file) {
            require_once $file;
        }

        $classes = get_declared_classes();
        foreach ($classes as $class) {
            $isSubClass = is_subclass_of($class, \App\Http\Controllers\Controller::class);
            try {
                $isAbstract = (new ReflectionClass($class))->isAbstract();

                if ($isSubClass && !$isAbstract && Str::startsWith($class, self::APP)) {
                    $controllers[] = $class;
                }
            } catch (ReflectionException) {

            }
        }

        return array_unique($controllers);
    }
}
