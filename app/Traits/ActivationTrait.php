<?php

namespace App\Traits;

use App\Http\Services\Activation as ActivationService;
use App\User as UserModel;
use Validator;

trait ActivationTrait
{
    public function initiateEmailActivation(UserModel $model)
    {
        if(!config('settings.activation') || !$this->validateEmail($model)){
            return true;
        }

        $activationService = new ActivationService();
        $activationService->createTokenAndSendMail($model);
    }

    protected function validateEmail(UserModel $model)
    {
        $validator = Validator::make(['email' => $model->email],['email' => 'required|email']);
        if($validator->fails()){
            return false;
        }

        return true;
    }
}