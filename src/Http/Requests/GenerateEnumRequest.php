<?php

namespace Uzinfocom\Dastyor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateEnumRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'variables' => 'required|array',
            'variables.*.key' => 'required',
            'variables.*.value' => 'required',
            'namespace' => 'required|string|max:255'
        ];
    }
}
