<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Nav
 * @package App\Http\Models
 * @version February 01, 2019, 11:24 am UTC
 *
 * @property string title
 * @property integer order
 * @property integer user_id
 * @property integer parent_id
 * @property string url
 * @property integer status
 */
class Nav extends Model
{

    public $table = 'nav';
    public $childs;

    public const STATUS_ON = 1;
    public const STATUS_OFF = 0;


    public $fillable = [
        'title',
        'order',
        'user_id',
        'parent_id',
        'url',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'order' => 'integer',
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'url' => 'string',
        'status' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'url' => 'required',
        'status' => 'required',
    ];

    public static function getNavbar()
    {
        $items = self::where(
            [
                ['status', '=', self::STATUS_ON],
                ['parent_id', '=', null]
            ]
        )->get();
       
        foreach ($items as &$item) {
        
            $item->childs = self::getChilds($item->id);
             
            foreach ($item->childs as &$child) {
            
                $child->childs = self::getChilds($child->id);
            }
        }
     
        return $items;
    }

    public static function getChilds($id)
    {
        $items = self::where(
            [
                ['status', '=', self::STATUS_ON],
                ['parent_id', '=', $id]
            ]
        )->get();

        return $items;
    }

    public static function getAll()
    {
        return self::all();
    }
}
