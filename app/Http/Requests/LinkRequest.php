<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file_id' => ['required', 'numeric'],
            'single_view' => 'nullable',
        ];
    }
}