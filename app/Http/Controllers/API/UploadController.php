<?php

namespace App\Http\Controllers\API;

use App\Traits\FileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

class UploadController extends Controller
{
    use FileHelper;

    public function __construct()
    {
    }

    public function upload(Request $request)
    {
        // TODO
        $this->uploadToS3($request->file('file'), (string) Str::uuid());
        return responder()->success([]);
    }

    public function getUriFromStorage(Request $request)
    {
        // TODO
        $uri = $this->generateUrl('abc.jpeg');

        return responder()->success(['url' => $uri]);
    }
}
