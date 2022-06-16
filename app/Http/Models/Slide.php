<?php

namespace App\Http\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Slide
 * @package App\Http\Models
 * @version February 01, 2019, 11:24 am UTC
 *
 * @property string filepath
 * @property integer order
 * @property integer user_id
 * @property integer status
 */
class Slide extends Model
{

    public $table = 'carousel_images';

    public const STATUS_ON = 1;
    public const STATUS_OFF = 0;


    public $fillable = [
        'filepath',
        'order',
        'user_id',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'filepath' => 'string',
        'order' => 'integer',
        'user_id' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'filepath' => 'required|max:255',
        'order' => 'required',
        'status' => 'required',
    ];

    public static function getAll()
    {
        $items = self::where(
            [
                ['status', '=', self::STATUS_ON],
            ]
        )->get();

        return $items;
    }

    public static function getAllShownOnTheHomepage()
    {
        $items = self::getAll();
        foreach ($items as &$item)
        {
            $item->filepath = ImageHelper::getThumbURL($item->filepath, 'slider');
        }

        return $items;
    }
}
