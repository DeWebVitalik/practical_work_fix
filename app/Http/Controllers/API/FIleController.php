<?php


namespace App\Http\Controllers\API;

use App\Helpers\UserFilePath;
use App\Http\Requests\FileRequest;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Facades\Log;

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
     * @param Request $request
     */
    public function store(FileRequest $request)
    {
        if ($file = $this->service->save($request)) {
            return $this->sendResponse($file, __('alert-message.upload_success'));
        } else {
            return $this->sendResponse($file, __('alert-message.upload_error'));
        }
    }


    /**
     * Download the specified file.
     *
     * @param File $file
     */
    public function show(File $file)
    {
        if ($this->service->isFileDelete($file)) {
            return $this->sendError(__('alert-message.file_not_found'));
        }

        return response()->download(UserFilePath::getFilePath($file->file_name, $file->user_id, true), $file->file_name);
    }


    /**
     * Remove the specified file from storage.
     *
     * @param File $file
     */
    public function destroy(File $file)
    {
        if ($this->service->isFileDelete($file)) {
            return $this->sendError(__('alert-message.file_already_deleted'));
        }

        if ($this->service->delete($file)) {
            return $this->sendResponse($file, __('alert-message.delete_success'));
        } else {
            return $this->sendResponse($file, __('alert-message.delete_error'));
        }

    }

}