<?php


namespace App\Http\Requests;


use App\TDO\LinkTdo;
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

    /**
     * Insert data
     *
     * @return LinkTdo
     */
    public function getDto(): LinkTdo
    {
        return new LinkTdo(
            $this->get('file_id'),
            $this->get('single_view')
        );
    }
}
