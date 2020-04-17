<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Services\FileService;
use App\File;

class FileController extends Controller
{
    protected FileService $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
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
            'files' => $file->files()
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
     */
    public function store(FileRequest $request)
    {
        if ($file = $this->service->save($request)) {
            return redirect()->route('files.index')
                ->with('success', __('alert-message.upload_success'));
        } else {
            return redirect()->route('files.create')
                ->with('error', __('alert-message.upload_error'));
        }
    }

    /**
     * Display the specified file.
     *
     * @param File $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(File $file)
    {
        if ($this->service->isFileDelete($file)) {
            abort(404);
        }

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
     * @throws \Exception
     */
    public function destroy(File $file)
    {
        if ($this->service->isFileDelete($file)) {
            abort(404);
        }

        if ($this->service->delete($file)) {
            return redirect()->route('files.index')
                ->with('success', __('alert-message.delete_success'));
        } else {
            return redirect()->route('files.index')
                ->with('error', __('alert-message.delete_error'));
        }
    }

}
