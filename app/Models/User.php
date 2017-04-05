<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Illuminate\Support\Facades\Hash;

/**
 * @SWG\Definition(required={"id", "first_name", "last_name", "email", "password", "user_level", "is_active"})
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * @SWG\Property(property="id", type="integer", format="int64")
     */

    /**
     * @SWG\Property(property="first_name", type="string")
     */

    /**
     * @SWG\Property(property="last_name", type="string")
     */

    /**
     * @SWG\Property(property="email", type="string")
     */

    /**
     * @SWG\Property(property="password", type="string")
     */

    /**
     * @SWG\Property(property="user_level", type="integer", format="int64")
     */

    /**
     * @SWG\Property(property="is_active", type="integer", format="int64")
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'password', 'user_level', 'is_active', 'pivot'
    ];

    /**
     * Verify user's credentials.
     *
     * @param  string $email
     * @param  string $password
     * @return int|boolean
     * @see    https://github.com/lucadegasperi/oauth2-server-laravel/blob/master/docs/authorization-server/password.md
     */
    public function verify($email, $password)
    {
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user->id;
        }

        return false;
    }

    public function userLevel()
    {
        return $this->user_level;
    }

    public function stores()
    {
        return $this->belongsToMany('App\Models\Store', 'users_to_stores', 'user_id', 'store_id')->select(array('id', 'street', 'phone_number'));
    }

    public function setPassword($password)
    {
        $hasher = app()->make('hash');
        $this->password = $hasher->make($password);
    }
}
