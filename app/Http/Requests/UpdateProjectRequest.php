<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'start_date' => ['date', 'required'],
            'end_date' => ['date', 'required'],
            'value' => ['numeric', 'required'],
            'status' => ['string', 'required'],
        ];
    }
}
