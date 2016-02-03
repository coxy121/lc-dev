<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Http\AuthTraits\OwnsRecord;
use Illuminate\Support\Facades\Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, OwnsRecord;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name',
                            'email',
                            'facebook_id',
                            'avatar',
                            'is_subscribed',
                            'is_admin',
                            'user_type_id',
                            'status_id',
                            'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function widgets()
    {
        return $this->hasMany('App\Widget');
    }

    /*
     * Check if the user is admin
     */
    public function isAdmin()
    {
        return Auth::user()->is_admin == 1;
    }

    /*
     * Checks if the user is active
     */
    public function isActiveStatus()
    {
        return Auth::user()->status_id == 10;
    }
}
