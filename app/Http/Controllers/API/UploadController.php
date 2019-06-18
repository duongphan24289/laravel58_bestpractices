<?php

namespace App\Http\Controllers\API;

use App\Traits\FileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    use FileHelper;

    public function __construct()
    {
    }

    public function upload(Request $request)
    {
        $data = $this->uploadToS3($request->file('file'), 'abc');

        return responder()->success($data);
    }
}
