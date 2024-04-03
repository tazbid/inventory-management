<?php

namespace App\Http\Requests\InventoryDetailsRequests;

use Illuminate\Foundation\Http\FormRequest;

class GetInventoryDetailsRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'page'    => 'required|integer|min:1',
            'perPage' => 'integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'page.required'    => 'Page is required',
            'page.integer'     => 'Page must be an integer',
            'page.min'         => 'Page must be at least 1',
            'perPage.integer'  => 'Per page must be an integer',
        ];
    }
}
