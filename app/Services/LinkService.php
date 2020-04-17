<?php


namespace App\Services;


use App\Http\Requests\LinkRequest;
use App\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\UserFilePath;

class LinkService
{
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

        $filePath =UserFilePath::getFilePath($link->file->file_name,$link->user_id);
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

}