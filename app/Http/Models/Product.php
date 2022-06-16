<?php

namespace App\Http\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model as Model;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class Product
 * @package App\Http\Models
 * @version March 31, 2019, 13:55 am UTC
 *
 * @property string title
 * @property string text
 * @property string description
 * @property integer user_id
 * @property integer seo_id
 * @property integer category_id
 * @property string slug
 * @property integer status
 * @property string name1
 * @property string name2
 * @property string name3
 * @property string detail1
 * @property string detail2
 * @property string detail3
 * @property float price1
 * @property float price2
 * @property float price3
 * @property string label
 * @property string image
 */
class Product extends Model
{

    public $table = 'store_products';
    public const LABEL_NORMAL = 'normal';
    public const LABEL_HOT = 'hot';
    public const LABEL_POPULAR = 'popular';

    public const STATUS_SHOW = 1;
    public const STATUS_HIDE = 0;

    public $parent;


    public $fillable = [
        'title',
        'text',
        'description',
        'slug',
        'status',
        'category_id',
        'user_id',
        'seo_id',
        'name1',
        'name2',
        'name3',
        'detail1',
        'detail2',
        'detail3',
        'price1',
        'price2',
        'price3',
        'label',
        'filepath'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'text' => 'string',
        'description' => 'string',
        'detail1' => 'string',
        'detail2' => 'string',
        'detail3' => 'string',
        'name1' => 'string',
        'name2' => 'string',
        'name3' => 'string',
        'price1' => 'float',
        'price2' => 'float',
        'price3' => 'float',
        'user_id' => 'integer',
        'seo_id' => 'integer',
        'category_id' => 'integer',
        'slug' => 'string',
        'status' => 'integer',
        'label' => 'string',
        'filepath' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'status' => 'required',
        'category_id' => 'required',
        'price1' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'filepath' => 'required|max:255',
//        'price2' => 'regex:/^$|/^\d+(\.\d{1,2})?$/',
//        'price3' => 'regex:/^$|/^\d+(\.\d{1,2})?$/'
    ];

    public function seo()
    {
        return $this->belongsTo('App\Http\Models\SeoMeta', 'seo_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Http\Models\Category', 'category_id', 'id');
    }

    public static function getLabels()
    {
        $labels = [
            [
                'id' => self::LABEL_NORMAL,
                'title' => trans('panel.product.fields.label.' . self::LABEL_NORMAL)
            ],
            [
                'id' => self::LABEL_HOT,
                'title' => trans('panel.product.fields.label.' . self::LABEL_HOT)
            ],
            [
                'id' => self::LABEL_POPULAR,
                'title' => trans('panel.product.fields.label.' . self::LABEL_POPULAR)
            ]
        ];
        return $labels;
    }

    public static function getAllThisCategory($categoryId)
    {
        $products = self::where([
            'category_id' => $categoryId,
            'status' => self::STATUS_SHOW
        ])->get();

        $i = 0;
        foreach ($products as &$product) {
            $i++;
            $product->title = str_replace(["'",'"'],'',$product->title);
            $product->filepath = ImageHelper::getThumbURL($product->filepath, 'product-long');
        }

        return $products;
    }

    public static function getAllShow()
    {
        $products = self::where('status','=',self::STATUS_SHOW)->get();

        $i = 0;
        foreach ($products as &$product) {
            $i++;
            $product->filepath = ImageHelper::getThumbURL($product->filepath, 'product');
        }

        return $products;
    }

    public static function createNewThumbSize($pSize, $width, $height, $path)
    {
        $files = scandir($path);

        foreach ($files as $file)
        {
            if($file !== '.' && $file !== '..' && $file !== '.DS_Store' && $file !== 'thumbs' && !is_dir($file))
            {

                $filePath = $path . '/' . $file;
                $filepathNew = ImageHelper::getThumbPath($filePath, $pSize);

                try
                {
                    $img = Image::make($filePath);
                    $img->fit($width, $height);
                    $img->save($filepathNew);
                }
                catch (\Exception $e)
                {
                    echo '===============================================><br>';
                    echo 'Поймано исключение: ',  $e->getMessage(), "\n";
                    echo "File => $filePath <br> Thumb => $filepathNew <br>";
                }
            }
        }

        exit();
    }
}
