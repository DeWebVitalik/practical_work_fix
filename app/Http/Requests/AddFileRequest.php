<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => ['required', 'max:255'],
            'date_remove' => ['nullable', 'date_format:d-m-Y', 'date'],
            'file' => ['required', 'max:5000'],
        ];
    }
}