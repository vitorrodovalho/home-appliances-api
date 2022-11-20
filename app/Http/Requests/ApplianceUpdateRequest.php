<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplianceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:45',
            'description' => 'string|max:255',
            'voltage' => 'integer|max-digits:3',
            'mark_id' => 'integer|exists:marks,id'
        ];
    }
}
