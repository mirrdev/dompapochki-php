<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Page
 * @package App\Http\Models
 * @version February 01, 2019, 11:24 am UTC
 *
 * @property string title
 * @property string text
 * @property integer user_id
 * @property integer seo_id
 * @property string slug
 * @property integer type
 * @property integer status
 */
class Page extends Model
{

    public $table = 'pages';


    public $fillable = [
        'title',
        'text',
        'user_id',
        'seo_id',
        'slug',
        'type',
        'status',
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
        'type' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'text' => 'required',
        'status' => 'required',
    ];

    public function getStatusAttribute($data)
    {
        return ($data == 1) ? '<i class="i-Eye text-success text-25"></i>' : '<i class="i-Eye text-black-50 text-25"></i>';
    }

    public function seo()
    {
        return $this->belongsTo('App\Http\Models\SeoMeta', 'seo_id', 'id');
    }
}
