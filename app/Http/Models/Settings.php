<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Page
 * @package App\Http\Models
 * @version February 01, 2019, 11:24 am UTC
 *
 * @property string title
 * @property string value
 * @property integer user_id
 * @property integer type
 * @property string key
 */
class Settings extends Model
{

    public $table = 'settings';

    public const STRING         = 0;
    public const EDITOR         = 1;
    public const TEXTAREA       = 2;
    public const INTEGER        = 3;
    public const FILE           = 4;
    public const DATE           = 5;
    public const DATETIME       = 6;
    public const HTML           = 7;
    public const SWITCHER       = 8;


    public $fillable = [
        'title',
        'user_id',
        'value',
        'type',
        'key'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'user_id' => 'integer',
        'value' => 'string',
        'type' => 'integer',
        'key' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'key' => 'required|max:100',
        'type' => 'required',
    ];

    public static $rulesUpdate = [
        'title' => 'required|max:255',
        'value' => 'required',
    ];

    public static function allCodes()
    {
        return [
            'STRING' => self::STRING,
            'EDITOR' => self::EDITOR,
            'TEXTAREA' => self::TEXTAREA,
            'INTEGER' => self::INTEGER,
            'FILE' => self::FILE,
            'DATE' => self::DATE,
            'DATETIME' => self::DATETIME,
            'HTML' => self::HTML,
            'SWITCHER' => self::SWITCHER,
        ];
    }

    public static function getTypes()
    {
        $types = self::allCodes();

        $typesArray = [];

        foreach ($types as $key => $type)
        {
            $typesArray[] = [
                'id' => $type,
                'name' => self::getName($key)
            ];
        }

        return $typesArray;
    }

    public static function getName($key)
    {
        return trans('panel.settings.types.' . $key);
    }

    public static function getValue($key)
    {
        $item = self::where('key', '=', $key)->first();
        return isset($item->value) ? $item->value : '';
    }

    public static function getFromHomepage()
    {
        $items = self::where('key', 'like', 'homepage_%')->get()->pluck('value', 'key');
        return $items;
    }

    public static function getFooter()
    {
        $items = self::where('key', 'like', 'footer_%')->get()->pluck('value', 'key');
        return $items;
    }
}
