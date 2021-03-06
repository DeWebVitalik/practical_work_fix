<?php

namespace App\Http\Requests;

use App\Rules\DuplicateFile;
use App\TDO\FileTdo;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'date_remove' => ['nullable', 'date_format:d-m-Y', 'date', 'after:' . date('d-m-Y')],
            'file' => ['required', 'image', 'max:5000', new DuplicateFile($this)],
        ];
    }

    /**
     * Insert data
     *
     * @return FileTdo
     */
    public function getDto(): FileTdo
    {
        return new FileTdo(
            $this->file('file')->getClientOriginalName(),
            $this->get('comment'),
            $this->get('date_remove'),
            $this->file('file')
        );
    }
}
