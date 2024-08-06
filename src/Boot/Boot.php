<?php

namespace Uzinfocom\LaravelGenerator\Boot;


use Illuminate\Support\HtmlString;

class Boot {
    public const ROOT = "generator";

    public static function getView(string $string): string {
        return self::ROOT . "::" . $string;
    }

    public static function getWire(string $string): string {
        return $string;
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
        ];
        $scripts = [];
        foreach ($files as $file) {
            $scripts[] = "<script src='" . asset('vendor/generator/assets/' . $file) . "'>" . "</script>";
        }
        $scripts = implode("\n", $scripts);
        return new HtmlString($scripts);
    }
}