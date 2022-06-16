<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Role
 * @package App\Http\Models
 * @version March 30, 2019, 23:24 am UTC
 *
 * @property string name
 * @property string display_name
 * @property string description
 */
class Role extends Model
{

    public $table = 'roles';


    public $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'display_name' => 'required|max:255',
        'description' => 'required|max:255',
    ];

    public static function getPermissionsItems($id)
    {
        $permissionsRole = Role::getPermissions($id)->pluck('permission_id')->toArray();
        $permissions = Permission::whereIn('id', $permissionsRole)->get();

        return $permissions;
    }

    public static function getPermissions($roleId)
    {
        $permissions = RolePermissions::where('role_id', '=', $roleId)->get();
        return $permissions;
    }

    public static function getPermissionsNames($id)
    {
        $permissionsRole = Role::getPermissions($id)->pluck('permission_id')->toArray();
        $permissions = Permission::whereIn('id', $permissionsRole)->get();
        $names = $permissions->pluck('display_name')->toArray();

        return $names;
    }

}
