<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\File;
use App\TDO\FileTdo;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $file = File::create([
            'user_id' => $user->id,
            'file_name' => $request->getFileName(),
            'comment' => $request->getComment(),
            'date_remove' => $request->getDateRemove()
                ? Carbon::parse($request->getDateRemove())->timestamp
                : null
        ]);

        if (!$file) {
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

        DB::beginTransaction();
        try {
            $file->links()->delete();
            $file->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw new ServiceException(__('alert-message.delete_error'));
        }
    }
}
