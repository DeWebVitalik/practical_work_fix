<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Link;
use App\Services\LinkService;
use Illuminate\Http\Request;

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
     * @param Link $link
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Link $link)
    {
        return view('link/index', [
            'links' => $link->links()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinkRequest $request)
    {
        $link = $this->service->save($request->getDto(), auth()->user());

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
     * @param Link $link
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws /Exception
     */
    public function destroy(Link $link, Request $request)
    {
        $link->delete();
        if ($request->ajax()) {

            return response()->json([
                'success' => __('alert-message.link_delete_success')
            ]);

        } else {
            return redirect()->route('links.index')
                ->with('success', __('alert-message.link_delete_success'));
        }
    }
}
