<?php


namespace App\Services;


use App\Http\Requests\LinkRequest;
use App\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
}