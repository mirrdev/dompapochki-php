<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Role
 * @package App\Http\Models
 * @version March 30, 2019, 23:24 am UTC
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string remember_token
 * @property string phone
 * @property string avatar
 */

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name', 'email', 'password', 'phone', 'avatar',
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'phone' => 'string',
        'avatar' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'email' => 'required:unique:users',
        'password' => 'max:255|min:6',
    ];

    public static function create($model)
    {
        $user = new User();
        $user->email = $model['email'];
        $user->name = $model['name'];
        $user->password = $model['password'];
        return $user->save();
    }

    public function getAvatarAttribute($data)
    {
        $default = asset('assets/images/faces/man.svg');
        return (is_null($data) || $data == '') ? $default : $data;
    }
}
