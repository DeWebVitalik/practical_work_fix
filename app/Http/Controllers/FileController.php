<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFileRequest;
use App\Services\FileService;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('file/index', [
            'files' => File::orderBy('created_at', 'DESC')
                ->where([
                    ['delete', File::NOT_DELETED],
                    ['user_id', Auth::id()]
                ])
                ->paginate(10)
        ]);
    }

    /**
     * Show the form for add a new file.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('file/create');
    }

    /**
     * Store a newly created file in storage.
     *
     * @param AddFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddFileRequest $request)
    {
        if ($this->service->save($request)) {
            return redirect()->route('files.index')->with('success', __('alert-message.upload_success'));
        } else {
            return redirect()->route('files.create')->with('error', __('alert-message.upload_error'));
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
        return view('file.show', compact('file'));
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
        if ($this->service->delete($file)) {
            return redirect()->route('files.index')->with('success', __('alert-message.delete_success'));
        } else {
            return redirect()->route('files.index')->with('error', __('alert-message.delete_error'));
        }
    }

}
