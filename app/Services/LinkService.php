<?php


namespace App\Services;


use App\Http\Requests\LinkRequest;
use App\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LinkService
{
    public const PATH_USER_FILES = 'public/user-files/';

    public function save(LinkRequest $request)
    {
        $link = Link::create([
            'user_id' => Auth::id(),
            'file_id' => $request->file_id,
            'single_view' => empty($request->single_view) ? 0 : 1,
            'alias' => Str::random(32),
        ]);
        return $link;
    }

    public function getFilePath(Link $link)
    {

        $filePath = $this->getUserPersonalPath() . '/' . $link->file->file_name;
        if (!Storage::exists($filePath)) {
            return false;
        }
        return $filePath;
    }

    public function checkAccess(Link $link)
    {
        if ($link->single_view == Link::SINGLE_VIEW && $link->views >= 1) {
            return false;
        }

        return true;
    }

    protected function getUserPersonalPath()
    {
        return self::PATH_USER_FILES . '/' . Auth::id();
    }
}