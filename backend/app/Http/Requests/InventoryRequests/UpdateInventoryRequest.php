<?php

namespace App\Http\Requests\InventoryRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest {
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
            'name'        => 'required|string|max:255|unique:inventories,name,' . $this->id,
            'description' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'name.required'        => 'Name is required',
            'name.string'          => 'Name must be a string',
            'name.max'             => 'Name must not exceed 255 characters',
            'name.unique'          => 'Name already exists',
            'description.required' => 'Description is required',
            'description.string'   => 'Description must be a string',
        ];
    }
}
