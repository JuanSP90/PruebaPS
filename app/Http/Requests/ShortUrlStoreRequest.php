<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortUrlStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'url' => 'required|url',
            'alias' => 'nullable|string',
            'description' => 'nullable|string'
        ];
    }

    /**
     *
     */
    public function messages()
    {
        return [
            'url.required' => 'URL is required',
            'url.url' => 'The URL format is invalid.',
        ];
    }
}
