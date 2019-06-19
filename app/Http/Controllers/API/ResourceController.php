<?php

namespace App\Http\Controllers\API;

use App\Traits\FileHelper;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    use FileHelper;

    public function __construct()
    {
    }

    public function getUrl($name)
    {
        $url = $this->generateUrl($name);

        return responder()->success(['image' => $url]);
    }
}
