<?php

namespace App;

use App\Presenters\PresentableTrait;
use App\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    const PERSONAL_ACCESS_TOKEN = 'Personal Access Token';

    use HasApiTokens, Notifiable, PresentableTrait;

    protected $dates = ['created_at', 'updated_at'];

//    Present user
    protected $presenter = UserPresenter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getSomeDateAttribute($date)
    {
        return $date->format('m-d');
    }

    public function generateToken()
    {
        return $this->createToken(self::PERSONAL_ACCESS_TOKEN);
    }
}
