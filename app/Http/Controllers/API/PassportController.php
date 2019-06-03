<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService as PrimaryService;

class PassportController extends Controller
{
    /*
     * UserService
     */
    protected $primaryService;

    public function __construct(
        PrimaryService $primaryService
    )
    {
        $this->primaryService = $primaryService;
    }

    public function store(UserRequest $request)
    {
        $user = $this->primaryService->create($request->validated());

        return responder()->success($user);
    }

    /**
     * Get detail user
     *
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function detail()
    {
        return responder()->success(auth()->user());
    }
}
