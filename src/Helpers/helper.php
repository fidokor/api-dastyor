<?php

if (!function_exists('customHelper')) {
    function customHelper($param) {
        dd($param);
    }
}

if (!function_exists('getModelNameFromModel')) {
    function getModelNameFromModel($path) {
        $path = explode('\\', $path);
        return end($path);
    }
}
