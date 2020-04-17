<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
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
     * @return string
     * @throws \Exception
     */
    public static function getUserPersonalPath(): string
    {
        if (!Auth::id()) {
            throw new \Exception('Authorized user ID not found');
        }

        return self::USER_FILES_PATH . Auth::id();
    }

    /**
     * Return full path to user file
     * The path includes a file name
     *
     * @param string $fileName
     * @param int|null $userId
     * @param bool $fullPath
     * @return string
     * @throws \Exception
     */
    public static function getFilePath(string $fileName, int $userId = null, $fullPath = false): string
    {
        if ($userId) {
            $personalPath = self::USER_FILES_PATH . $userId;
        } else {
            $personalPath = self::getUserPersonalPath();
        }

        $filePath = $personalPath . '/' . $fileName;

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