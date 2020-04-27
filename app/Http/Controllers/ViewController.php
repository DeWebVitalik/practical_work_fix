<?php


namespace App\Http\Controllers;


use App\Helpers\UserFilePath;
use App\Link;
use App\Services\LinkService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ViewController extends Controller
{
    protected LinkService $service;

    public function __construct(LinkService $service)
    {
        $this->service = $service;
    }

    /**
     * Displays the file by the specified alias
     *
     * @param string $alias
     * @return \Illuminate\Http\Response
     */
    public function index(string $alias)
    {
        $link = Link::where('alias', $alias)->firstOrFail();

        $filePath = UserFilePath::getFilePath($link->file->file_name, $link->user_id);

        if (!$this->service->checkAccess($link) || !Storage::exists($filePath)) {
            abort(404);
        }

        event('linkViewed', $link);

        $file = Storage::get($filePath);
        $type = Storage::mimeType($filePath);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

}
