<?php


namespace App\Services;


use App\Helpers\UserFilePath;
use App\TDO\FileTdo;

class UploadFileService
{
    /**
     * Upload file
     *
     * @param FileTdo $request
     * @param int $userId
     * @throws \Exception
     */
    public function upload(FileTdo $request, int $userId): void
    {
        $fileName = $request->getFile()->getClientOriginalName();
        $userPath = UserFilePath::getUserPersonalPath($userId);
        $request->getFile()->storePubliclyAs($userPath, $fileName);
    }
}
