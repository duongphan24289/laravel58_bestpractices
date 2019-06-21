<?php
namespace App\Http\Services;

use App\Notifications\SendActivationMail;
use App\Repositories\ActivationRepository;
use App\User;
use Carbon\Carbon;
use Str;

class Activation
{
    protected $activationRepository;

    public function __construct()
    {
        $this->activationRepository = app(ActivationRepository::class);
    }

    public function createTokenAndSendMail(User $user)
    {

        $activation = $this->activationRepository->findWhere([
            'user_id' => $user->id,
            'created_at' => Carbon::now()->subHours(config('settings.timePeriod'))
        ])->count();

        if($activation >= config('settings.maxAttempts')) {
            return true;
        }

        $activation = self::createNewActivationToken($user);

        // send token
        self::sendNewActivationEmail($user, $activation->token);

    }

    private function createNewActivationToken(User $user)
    {
        return $this->activationRepository->create([
            'user_id' => $user->id,
            'token' => Str::random(64)
        ]);
    }

    private function sendNewActivationEmail(User $user, $token)
    {
        $user->notify(new SendActivationMail($token));
    }

}