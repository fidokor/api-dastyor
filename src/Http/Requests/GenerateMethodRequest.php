<?php

namespace Uzinfocom\LaravelGenerator\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateMethodRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'namespace' => 'required|string',
            'name' => 'required|string|between:2,255',
        ];
    }
}