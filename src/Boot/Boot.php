<?php

namespace Uzinfocom\LaravelGenerator\Boot;

class Boot {
    public const ROOT = "generator";

    public static function getView(string $string): string {
        return self::ROOT . "::" . $string;
    }

    public static function getWire(string $string): string {
        return $string;
    }
}