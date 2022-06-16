<?php

namespace App\Http\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Category
 * @package App\Http\Models
 * @version March 31, 2019, 13:55 am UTC
 *
 * @property string title
 * @property string text
 * @property integer user_id
 * @property integer seo_id
 * @property string slug
 * @property integer parent_id
 * @property integer status
 * @property string filepath
 * @property integer show_on_homepage
 * @property integer show_in_navigate
 */
class Category extends Model
{

    public $table = 'store_categories';

    public const STATUS = ['on' => 1, 'off' => 0];


    public $fillable = [
        'title',
        'text',
        'status',
        'user_id',
        'seo_id',
        'slug',
        'parent_id',
        'filepath',
        'show_on_homepage',
        'show_in_navigate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'text' => 'string',
        'user_id' => 'integer',
        'seo_id' => 'integer',
        'slug' => 'string',
        'parent_id' => 'integer',
        'status' => 'integer',
        'filepath' => 'string',
        'show_on_homepage' =>'integer',
        'show_in_navigate' =>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'status' => 'required',
        'filepath' => 'required',
        'show_on_homepage' => 'required',
        'show_in_navigate' => 'required',
    ];

    public function seo()
    {
        return $this->belongsTo('App\Http\Models\SeoMeta', 'seo_id', 'id');
    }

    public static function getAll()
    {
        $categories = self::where('status','=',self::STATUS['on'])->get();
        return $categories;
    }

    public static function getAllShownOnTheHomepage()
    {
        $categories = self::where('show_on_homepage','=',self::STATUS['on'])->orderBy('order_home','asc')->get();

        $i = 0;
        foreach ($categories as &$category) {
            $i++;
            $category->filepath = ImageHelper::getThumbURL($category->filepath, ($i<3)?'middle':'small');
        }

        return $categories;
    }

    public static function getAllShownInNav()
    {
        $categories = self::where('show_in_navigate','=',self::STATUS['on'])->get();
        return $categories;
    }
}
