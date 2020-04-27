<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class UserFilePath
{
    /**
     * Path to the directory with users folders
     */
    protected const USER_FILES_PATH = 'public/user-files/';

    /**
     * Returns the path to user folder
     *
     * @param int $userId
     * @return string
     */
    public static function getUserPersonalPath(int $userId): string
    {
        return self::USER_FILES_PATH . $userId;
    }

    /**
     * Return full path to user file
     * The path includes a file name
     *
     * @param string $fileName
     * @param int $userId
     * @param bool $fullPath
     * @return string
     */
    public static function getFilePath(string $fileName, int $userId, $fullPath = false): string
    {
        $filePath = self::getUserPersonalPath($userId) . '/' . $fileName;

        $filePath = $fullPath ? storage_path('app/' . $filePath) : $filePath;

        return $filePath;
    }

    /**
     * Create user folder
     *
     * @param int $userId
     */
    public static function createUserDirectory(int $userId): void
    {
        Storage::makeDirectory(self::USER_FILES_PATH . '/' . $userId);
    }

}
