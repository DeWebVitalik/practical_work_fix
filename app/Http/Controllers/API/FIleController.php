<?php


namespace App\Http\Controllers\API;

use App\Helpers\UserFilePath;
use App\Http\Requests\FileRequest;
use App\Services\FileService;
use App\File;
use Illuminate\Support\Facades\Storage;

class FIleController extends BaseController
{

    protected FileService $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created file in storage.
     *
     * @param FileRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(FileRequest $request)
    {
        if ($file = $this->service->save($request->getDto(), auth()->user())) {
            return $this->sendResponse($file, __('alert-message.upload_success'));
        } else {
            return $this->sendResponse($file, __('alert-message.upload_error'));
        }
    }


    /**
     * Download the specified file.
     *
     * @param File $file
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function show(File $file)
    {
        $filePath = UserFilePath::getFilePath($file->file_name, $file->user_id, true);

        if (Storage::exists($filePath)) {
            return $this->sendError(__('alert-message.file_not_found'));
        }

        return response()->download($filePath, $file->file_name);
    }


    /**
     * Remove the specified file from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(File $file)
    {
        if ($this->service->delete($file)) {
            return $this->sendResponse($file, __('alert-message.delete_success'));
        } else {
            return $this->sendResponse($file, __('alert-message.delete_error'));
        }

    }

}
