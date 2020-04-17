<?php

namespace App\Services;

use App\Http\Requests\FileRequest;
use App\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UserFilePath;

class FileService
{


    public function save(FileRequest $request)
    {
        $fileName = $this->uploadFile($request);

        $userFile = File::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'comment' => $request->comment,
            'date_remove' => $this->dateRemoveInTimestamp($request->date_remove)
        ]);

        return $userFile;
    }

    public function delete(File $file)
    {
        if (!Storage::delete(UserFilePath::getFilePath($file->file_name))) {
            return false;
        }

        event('deleteFile', $file);

        return true;
    }

    public function isFileDelete(File $file)
    {
        if ($file->delete != File::DELETED) {
            return false;
        }

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
        $request->file('file')->storePubliclyAs(UserFilePath::getUserPersonalPath(), $fileName);
        return $fileName;
    }

}