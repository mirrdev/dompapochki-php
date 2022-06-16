<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class RolePermissions
 * @package App\Http\Models
 * @version March 31, 2019, 01:15 am UTC
 *
 * @property integer role_id
 * @property integer permission_id
 */
class RolePermissions extends Model
{

    public $table = 'permission_role';
    public $timestamps = false;

}
