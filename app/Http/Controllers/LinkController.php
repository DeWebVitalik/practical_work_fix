<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Link;
use App\Services\LinkService;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    protected LinkService $service;

    public function __construct(LinkService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('link/index', [
            'links' => Link::orderBy('created_at', 'DESC')
                ->where('user_id', Auth::id())
                ->with('file')
                ->paginate(10)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param FileRequest $request
     */
    public function store(LinkRequest $request)
    {
        $link = $this->service->save($request);
        return response()->json([
            'success' => __('alert-message.link_generate_success', ['link' => $link->alias]),
            'link' => [
                'id' => $link->id,
                'alias' => $link->alias,
                'created_at' => $link->created_at,
                'views' => 0,
                'single_view' => $link->single_view
            ]
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Link $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()->route('links.index')->with('success', __('alert-message.link_delete_success'));
    }
}
