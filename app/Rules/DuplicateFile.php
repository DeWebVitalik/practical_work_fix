<?php

namespace App\Rules;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DuplicateFile implements Rule
{
    protected $fileName;

    /**
     * Set file name
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->file('file')) {
            $this->fileName = $request->file('file')->getClientOriginalName();
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $file = File::where([
            ['file_name', '=', $this->fileName],
            ['user_id', '=', Auth::id()],
            ['delete', '=', File::NOT_DELETED]
        ])->get();
        return $file->isEmpty() ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.custom.file.duplication');
    }
}
