<?php
namespace App;
use App\ModelTraits\HasModelTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\Http\AuthTraits\OwnsRecord;
class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasModelTrait, OwnsRecord;
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
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
    public function widgets()
    {
        return $this->hasMany('App\Widget');
    }
    public function isAdmin()
    {
        return Auth::user()->is_admin == 1;
    }
    public function isActiveStatus()
    {
        return Auth::user()->status_id == 10;
    }
    public function updateUser($user, UserRequest $request)
    {
        return  $user->update(['name'  => $request->name,
            'email' => $request->email,
            'is_subscribed' => $request->is_subscribed,
            'is_admin' => $request->is_admin,
            'user_type_id' => $request->user_type_id,
            'status_id' => $request->status_id,
        ]);
    }
    public function showAdminStatusOf($user)
    {
        return $user->is_admin ? 'Yes' : 'No';
    }
    public function showNewsletterStatusOf($user)
    {
        return $user->is_subscribed == 1 ? 'Yes' : 'No';
    }
    public function showTypeOf($user)
    {
        switch ($user) {
            case $user->user_type_id == 10:
                return 'Free';
                break;
            case $user->user_type_id == 20:
                return 'Paid';
                break;
            default:
                return 'Free';
        }
    }
}