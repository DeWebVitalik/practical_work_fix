<?php


namespace App\Services;


use App\File;
use App\Http\Requests\LinkRequest;
use App\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class LinkService
{
    /**
     * Create alias for file
     *
     * @param LinkRequest $request
     * @return Link
     */
    public function save(LinkRequest $request): Link
    {
        return Link::create([
            'user_id' => Auth::id(),
            'file_id' => $request->file_id,
            'single_view' => empty($request->single_view) ? 0 : 1,
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
     * @param LinkRequest $request
     * @return bool
     */
    public function isFileNotExist(LinkRequest $request): bool
    {
        $file = File::where('id', $request->file_id)->get();
        return $file->isEmpty();
    }

}