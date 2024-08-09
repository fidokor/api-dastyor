<?php

namespace Uzinfocom\LaravelGenerator\Boot;


use Illuminate\Support\HtmlString;

class Boot {
    public const ROOT = "generator";

    public static function getView(string $name): string {
        return self::ROOT . "::" . $name;
    }

    /**
     * name -> Print working directory
     * @param string $directory
     * @return string
     */
    public static function getPwd(string $directory): string {
        return __DIR__ . "/../../" . $directory;
    }

    public static function getDatabase(string $filename): string {
        return self::getPwd("database/$filename");
    }

    public static function getWire(string $wire): string {
        return $wire;
    }

    public static function css(): HtmlString {
        $files = [
            "css/tabler-icons.css",
            "css/core.css",
            "css/theme-default.css",
            "css/demo.css",
        ];
        $styles = [];
        foreach ($files as $file) {
            $styles[] = "<link rel='stylesheet' href='" . asset('vendor/generator/assets/' . $file) . "' />";
        }
        $styles = implode("\n", $styles);
        return new HtmlString($styles);
    }

    public static function js(): HtmlString {
        $files = [
            "js/jquery.js",
            "js/bootstrap.js",
        ];
        $scripts = [];
        foreach ($files as $file) {
            $scripts[] = "<script src='" . asset('vendor/generator/assets/' . $file) . "'>" . "</script>";
        }
        $scripts = implode("\n", $scripts);
        return new HtmlString($scripts);
    }
}