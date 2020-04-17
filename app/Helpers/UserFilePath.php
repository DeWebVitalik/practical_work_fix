<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserFilePath
{
    public const PATH_USER_FILES = 'public/user-files/';

    public static function getUserPersonalPath()
    {
        if (!Auth::id()) {
            throw new \Exception('Authorized user ID not found');
        }

        return self::PATH_USER_FILES . Auth::id();
    }

    public static function getFilePath(string $fileName, int $userId = null)
    {
        if ($userId) {
            $personalPath = self::PATH_USER_FILES . $userId;
        } else {
            $personalPath = self::getUserPersonalPath();
        }

        return $personalPath . '/' . $fileName;
    }
}