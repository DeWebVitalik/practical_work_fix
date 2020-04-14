<?php

namespace App\Services;

use App\Http\Requests\AddFileRequest;
use App\UserFiles;
use Carbon\Carbon;

class FileService
{
    public function save(AddFileRequest $request)
    {
        $fileName = $this->uploadFile($request);

        $userFile = new UserFiles();

        $userFile->fill([
            'file_name' => $fileName,
            'comment' => $request->comment,
            'date_remove' => $this->DateRemoveInTimestamp($request->date_remove)
        ]);

        return $userFile->save();
    }

    protected function DateRemoveInTimestamp(string $date = null)
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
        $request->file('file')->storePubliclyAs('public/user-files', $fileName);
        return $fileName;
    }
}