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
    /**
     * Upload the file and save the request data to the database
     *
     * @param FileRequest $request
     * @return File
     * @throws \Exception
     */
    public function save(FileRequest $request): File
    {
        $fileName = $this->uploadFile($request);

        return File::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'comment' => $request->comment,
            'date_remove' => $request->date_remove ? Carbon::parse($request->date_remove)->timestamp : null
        ]);
    }

    /**
     * Delete the file and set the status to deleted
     *
     * @param File $file
     * @return bool
     * @throws \Exception
     */
    public function delete(File $file): bool
    {
        if (!Storage::delete(UserFilePath::getFilePath($file->file_name))) {
            return false;
        }

        $file->links()->delete();

        return $file->delete();
    }

    /**
     * Checks in the database the file has a deleted status
     *
     * @param File $file
     * @return bool
     */
    public function isFileDelete(File $file): bool
    {
        return $file->trashed();
    }

    /**
     * Upload file
     *
     * @param FileRequest $request
     * @return string
     * @throws \Exception
     */
    protected function uploadFile(FileRequest $request): string
    {
        if (!$request->hasFile('file')) {
            throw new \Exception('File not found');
        }

        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storePubliclyAs(UserFilePath::getUserPersonalPath(), $fileName);
        return $fileName;
    }

}
