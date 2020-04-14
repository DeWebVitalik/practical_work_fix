<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFileRequest;
use App\Services\FileService;
use App\UserFiles;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for add a new file.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file/create');
    }

    /**
     * Store a newly created file in storage.
     *
     * @param AddFileRequest $request
     */
    public function store(AddFileRequest $request)
    {
        if ($this->service->save($request)) {
            return redirect()->route('file.index');
        } else {
            return redirect()->route('file.create');
        }
    }

    /**
     * Display the specified file.
     *
     * @param \App\UserFiles $userFiles
     * @return \Illuminate\Http\Response
     */
    public function show(UserFiles $userFiles)
    {
        //
    }


    /**
     * Remove the specified file from storage.
     *
     * @param \App\UserFiles $userFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFiles $userFiles)
    {
        //
    }
}
