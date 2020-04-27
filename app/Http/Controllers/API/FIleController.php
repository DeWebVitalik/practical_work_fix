<?php


namespace App\Http\Controllers\API;

use App\Helpers\UserFilePath;
use App\Http\Requests\FileRequest;
use App\Services\FileService;
use App\File;
use App\Http\Resources\File as FileResource;
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
     * @return FileResource
     * @throws \App\Exceptions\ServiceException
     */
    public function store(FileRequest $request)
    {
        $file = $this->service->save($request->getDto(), auth()->user());
        return new FileResource($file);
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

        if (!Storage::exists(UserFilePath::getFilePath($file->file_name, $file->user_id))) {
            return $this->sendError(__('alert-message.file_not_found'));
        }

        return response()->download($filePath, $file->file_name);
    }


    /**
     * Remove the specified file from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ServiceException
     */
    public function destroy(File $file)
    {
        $this->service->delete($file, auth()->id());
        return $this->sendInformationResponse(__('alert-message.delete_success'));
    }

}
