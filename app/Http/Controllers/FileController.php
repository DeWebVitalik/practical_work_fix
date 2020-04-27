<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Services\FileService;
use App\File;
use App\Services\UploadFileService;

class FileController extends Controller
{
    protected FileService $service;
    protected UploadFileService $uploadFileService;

    public function __construct(FileService $service, UploadFileService $uploadFileService)
    {
        $this->service = $service;
        $this->uploadFileService = $uploadFileService;
    }

    /**
     * Display a listing of the file.
     *
     * @param File $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(File $file)
    {
        return view('file.index', [
            'files' => $file->files(auth()->id())
        ]);
    }

    /**
     * Show the form for add a new file.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Store a newly created file in storage.
     *
     * @param FileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\ServiceException
     */
    public function store(FileRequest $request)
    {
        $this->service->save($request->getDto(), auth()->user());

        $this->uploadFileService->upload($request->getDto(), auth()->id());

        return redirect()
            ->route('files.index')
            ->with('success', __('alert-message.upload_success'));
    }

    /**
     * Display the specified file.
     *
     * @param File $file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(File $file)
    {
        return view('file.show', [
            'file' => $file,
            'generalLinks' => $file->generalLinks(),
            'oneTimeLinks' => $file->oneTimeLinks()
        ]);
    }

    /**
     * Remove the specified file from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\ServiceException
     */
    public function destroy(File $file)
    {
        $this->service->delete($file, auth()->id());

        return redirect()
            ->route('files.index')
            ->with('success', __('alert-message.delete_success'));

    }

}
