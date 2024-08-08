<?php

namespace Uzinfocom\LaravelGenerator\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrudRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'model.name' => 'required|string|between:2,255',
            'model.namespace' => 'required|string|between:2,255',
            // controller
            'controller.base' => 'required|string|between:2,255',
            'controller.prefix' => 'required|string|between:2,255',
            'controller.name' => 'required|string|between:2,255',
            'controller.suffix' => 'required|string|between:2,255',
            // create request
            'request.create.prefix' => 'required|string|between:2,255',
            'request.create.name' => 'required|string|between:2,255',
            'request.create.suffix' => 'required|string|between:2,255',
            // update request
            'request.update.prefix' => 'required|string|between:2,255',
            'request.update.name' => 'required|string|between:2,255',
            'request.update.suffix' => 'required|string|between:2,255',

            // crud
            'crud.type' => 'required|string|between:2,255',
        ];
    }
}
