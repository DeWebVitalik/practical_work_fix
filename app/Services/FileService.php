<?php

namespace App\Services;

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
     * @throws \Exception
     */
    public function save(FileTdo $request, User $user): File
    {
        $this->uploadFile($request, $user->id);

        return File::create([
            'user_id' => $user->id,
            'file_name' => $request->getFileName(),
            'comment' => $request->getComment(),
            'date_remove' => $request->getDateRemove()
                ? Carbon::parse($request->getDateRemove())->timestamp
                : null
        ]);
    }

    /**
     *  Delete the file and set the status to deleted
     *
     * @param File $file
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public function delete(File $file, int $userId): bool
    {
        if (!Storage::delete(UserFilePath::getFilePath($file->file_name, $userId))) {
            return false;
        }

        $file->links()->delete();

        return $file->delete();
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
