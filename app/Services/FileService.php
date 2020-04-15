<?php

namespace App\Services;

use App\Http\Requests\AddFileRequest;
use App\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FileService
{
    public const PATH_USER_FILES = 'public/user-files/';


    public function save(AddFileRequest $request)
    {
        $fileName = $this->uploadFile($request);

        $userFile = new File();

        $userFile->fill([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'comment' => $request->comment,
            'date_remove' => $this->dateRemoveInTimestamp($request->date_remove)
        ]);

        return $userFile->save();
    }

    protected function dateRemoveInTimestamp(string $date = null)
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->timestamp;
    }

    protected function uploadFile(AddFileRequest $request)
    {
        if (!$request->hasFile('file')) {
            throw new \Exception('File not found');
        }

        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storePubliclyAs($this->getUserPersonalPath(), $fileName);
        return $fileName;
    }

    protected function getUserPersonalPath()
    {
        return self::PATH_USER_FILES . '/' . Auth::id();
    }
}