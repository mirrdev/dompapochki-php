<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class SeoMeta
 * @package App\Http\Models
 * @version February 01, 2019, 11:24 am UTC
 *
 * @property integer id
 * @property string title
 * @property string description
 * @property integer user_id
 */
class SeoMeta extends Model
{
    public $table = 'seo';

    public $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'user_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public $rules = [
        'title' => 'max:255',
        'description' => 'max:255',
    ];

    public static function create($data)
    {
        $model = $data['seo'];

        $seo = new self;
        $seo->title = $model['title'];
        $seo->description = $model['description'];
        $seo->user_id = Auth::user()->getAuthIdentifier();
        $seo->save();

        return $seo->id;
    }

    public static function edit($data, $id)
    {
        $model = $data['seo'];

        $seo = self::find($id);
        $seo->title = $model['title'];
        $seo->description = $model['description'];
        $seo->user_id = Auth::user()->getAuthIdentifier();
        $seo->save();

        return $seo->id;
    }
}
