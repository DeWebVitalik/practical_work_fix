<?php

namespace App\Services;

use App\Http\Requests\FileRequest;
use App\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public const PATH_USER_FILES = 'public/user-files/';


    public function save(FileRequest $request)
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

    public function delete(File $file)
    {
        if (!Storage::delete($this->getUserPersonalPath() . '/' . $file->file_name)) {
            return false;
        }

        event('deleteFile', $file);

        return true;
    }

    protected function dateRemoveInTimestamp(string $date = null)
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->timestamp;
    }

    protected function uploadFile(FileRequest $request)
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