<?php


namespace App\Http\Controllers\API;


use App\Http\Requests\LinkRequest;
use App\Services\LinkService;


class LinkController extends BaseController
{
    protected LinkService $service;

    public function __construct(LinkService $service)
    {
        $this->service = $service;
    }


    /**
     * Generation link.
     *
     * @param LinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generation(LinkRequest $request)
    {
        if ($this->service->isFileNotExist($request)) {
            return $this->sendError(__('alert-message.file_not_found'));
        }

        $link = $this->service->save($request);
        if ($link) {

            return $this->sendResponse([
                'url' => $link->alias,
                'single_view' => $link->single_view == 1 ? true : false
            ], __('alert-message.generation_link_success'));

        } else {
            return $this->sendError(__('alert-message.error_generation_link'));
        }
    }
}