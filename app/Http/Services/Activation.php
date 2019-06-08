<?php
namespace App\Http\Services;

use App\Repositories\ActivationRepository;
use App\User;

class Activation
{
    protected $activationRepository;

    public function __construct()
    {
        $this->activationRepository = ActivationRepository::class;
    }

    public function createTokenAndSendMail(User $user)
    {
        $activation = $this->activationRepository->
    }
}