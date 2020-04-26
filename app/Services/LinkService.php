<?php


namespace App\Services;

use App\Link;
use App\File;
use App\TDO\LinkTdo;
use Illuminate\Support\Str;
use App\User;

class LinkService
{
    /**
     * Create alias for file
     *
     * @param LinkTdo $request
     * @param User $user
     * @return Link
     */
    public function save(LinkTdo $request, User $user): Link
    {
        return Link::create([
            'user_id' => $user->id,
            'file_id' => $request->getFileId(),
            'single_view' => empty($request->getSingleView()) ? 0 : 1,
            'alias' => Str::random(32),
        ]);
    }

    /**
     * Checks whether an alias is one-time and has been used
     *
     * @param Link $link
     * @return bool
     */
    public function checkAccess(Link $link): bool
    {
        if ($link->single_view == Link::SINGLE_VIEW && $link->views >= 1) {
            return false;
        }

        return true;
    }

    /**
     * @param LinkTdo $request
     * @return bool
     */
    public function isFileNotExist(LinkTdo $request): bool
    {
        $file = File::where('id', $request->getFileId())->get();
        return $file->isEmpty();
    }

}
