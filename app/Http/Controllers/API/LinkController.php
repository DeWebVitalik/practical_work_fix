<?php


namespace App\Http\Controllers\API;

use App\Http\Requests\LinkRequest;
use App\Services\LinkService;
use App\Http\Resources\Link as LinkResources;

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
     * @return LinkResources|\Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ServiceException
     */
    public function generation(LinkRequest $request)
    {
        if ($this->service->isFileNotExist($request->getDto())) {
            return $this->sendError(__('alert-message.file_not_found'));
        }

        $link = $this->service->save($request->getDto(), auth()->user());
        return new LinkResources($link);

    }
}
