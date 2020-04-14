<?php

namespace App\Http\Controllers;

use App\UserFiles;
use Illuminate\Http\Request;

class FileController extends Controller
{
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
     * Display the specified file.
     *
     * @param  \App\UserFiles  $userFiles
     * @return \Illuminate\Http\Response
     */
    public function show(UserFiles $userFiles)
    {
        //
    }


    /**
     * Remove the specified file from storage.
     *
     * @param  \App\UserFiles  $userFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFiles $userFiles)
    {
        //
    }
}
