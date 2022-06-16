<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Permission
 * @package App\Http\Models
 * @version March 30, 2019, 23:24 am UTC
 *
 * @property string name
 * @property string display_name
 * @property string description
 */
class Permission extends Model
{

    public $table = 'permissions';


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

}
