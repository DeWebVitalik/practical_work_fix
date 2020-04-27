<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\File;
use App\TDO\FileTdo;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UserFilePath;

class FileService
{
    /**
     * Upload the file and save the request data to the database
     *
     * @param FileTdo $request
     * @param User $user
     * @return File
     * @throws ServiceException
     */
    public function save(FileTdo $request, User $user): File
    {
        $this->uploadFile($request, $user->id);

        $file=File::create([
            'user_id' => $user->id,
            'file_name' => $request->getFileName(),
            'comment' => $request->getComment(),
            'date_remove' => $request->getDateRemove()
                ? Carbon::parse($request->getDateRemove())->timestamp
                : null
        ]);

        if(!$file){
            throw new ServiceException(__('alert-message.upload_error'));
        }

        return $file;
    }

    /**
     * Delete the file and set the status to deleted
     *
     * @param File $file
     * @param int $userId
     * @throws ServiceException
     */
    public function delete(File $file, int $userId): void
    {
        if (!Storage::delete(UserFilePath::getFilePath($file->file_name, $userId))) {
            throw new ServiceException("Error deleting file '{$file->file_name}' from repository");
        }

        if (!$file->links()->delete() || !$file->delete()) {
            throw new ServiceException(__('alert-message.delete_error'));
        }
    }

    /**
     * Upload file
     *
     * @param FileTdo $request
     * @param int $userId
     * @throws \Exception
     */
    protected function uploadFile(FileTdo $request, int $userId): void
    {
        $fileName = $request->getFile()->getClientOriginalName();
        $userPath = UserFilePath::getUserPersonalPath($userId);
        $request->getFile()->storePubliclyAs($userPath, $fileName);
    }

}
