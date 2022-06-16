<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Order
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
class Order extends Model
{

    public $table = 'store_orders';

    public const STATUS_NEW                 = 0;
    public const STATUS_TREATMENT           = 1;
    public const STATUS_COOKING             = 2;
    public const STATUS_DELIVERY_SUCCESS    = 3;
    public const STATUS_REMOVE              = 4;
    public const STATUS_PAY_PROGRESS        = 5;
    public const STATUS_PAY_CANCEL          = 6;
    public const STATUS_PAY_SUCCESS         = 7;

    public static function getAllStatus()
    {
        $status = [
            [
                'status' => self::STATUS_NEW,
                'class' => 'success',
                'trans' => trans(strtolower('panel.order.status.fields.NEW')),
            ],
            [
                'status' => self::STATUS_TREATMENT,
                'class' => 'info',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.TREATMENT')),
            ],
            [
                'status' => self::STATUS_COOKING,
                'class' => 'info',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.COOKING')),
            ],
            [
                'status' => self::STATUS_DELIVERY_SUCCESS,
                'class' => 'info',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.DELIVERY.SUCCESS')),
            ],
            [
                'status' => self::STATUS_REMOVE,
                'class' => 'danger',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.REMOVE')),
            ],
            [
                'status' => self::STATUS_PAY_PROGRESS,
                'class' => 'warning',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.PAY.PROGRESS')),
            ],
            [
                'status' => self::STATUS_PAY_CANCEL,
                'class' => 'danger',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.PAY.CANCEL')),
            ],
            [
                'status' => self::STATUS_PAY_SUCCESS,
                'class' => 'success',
                'trans' => trans(strtolower('panel.order.status.fields.STATUS.PAY.SUCCESS')),
            ],
        ];

        return $status;
    }
    public static function getAllStatusStyles($status)
    {
        $statusItems = [];

        foreach ($status as $item) {
            $statusItems[] = [
                $item['status'] => "<span class='text-'{$item['class']}>{$item['trans']}</span>"
            ];
        }

        return $statusItems;
    }
    public static function getAllStatusTrans($status)
    {
        $statusItems = [];

        foreach ($status as $item) {
            $statusItems[] = [
                $item['status'] => $item['trans']
            ];
        }

        return $statusItems;
    }

    public static function returnSumAll()
    {
        $items = self::all();
        $sum = 0;
        foreach ($items as $item) {
            if(!empty($item->price) && !is_null($item->price))
            {
                $sum += $item->price;
            }
        }

        return $sum;
    }

    public static function getSumPeriod($period, $delimiter)
    {
        $sumPeriod = [];
        $items = DB::select("SELECT SUM(price) as month FROM store_orders Where created_at > DATE_ADD(NOW(),INTERVAL $period) and created_at <= NOW() GROUP BY $delimiter(created_at)");

        foreach ($items as $item) {
            $sumPeriod[] = $item->month;
        }

        return $sumPeriod;
    }

    public static function getSumString($sumPeriod)
    {
        $stringSumPeriod = implode(', ', $sumPeriod);

        return $stringSumPeriod;
    }

    public static function returnSum($sumPeriod)
    {
        $sum = 0;
        foreach ($sumPeriod as $item) {
            $sum += $item;
        }

        return $sum;
    }

    public static function getShortMonthsNames($type = 'array')
    {
        $months = [
            1 => trans('month.short.jan'),
            2 => trans('month.short.feb'),
            3 => trans('month.short.mar'),
            4 => trans('month.short.apr'),
            5 => trans('month.short.may'),
            6 => trans('month.short.jun'),
            7 => trans('month.short.jul'),
            8 => trans('month.short.aug'),
            9 => trans('month.short.sept'),
            10 => trans('month.short.oct'),
            11 => trans('month.short.nov'),
            12 => trans('month.short.dec'),
        ];

        if($type == 'string')
        {
            $months = implode(', ', $months);
        }

        return $months;
    }

    public static function getMonthsSortString($period)
    {
        $months = self::getShortMonthsNames();
        $m = (int) date('m', strtotime($period));
        $all = ($m !== 1) ? 12 + $m - 1 : 12;
        $monthsSortString = '';

        for($i = $m; $i<=$all; $i++)
        {
            $j = ($i<=12) ? $i : $i-12;
            $month = $months[$j];

            $monthsSortString .= (empty($monthsSortString)) ? '' : ', ';
            $monthsSortString .= '"' . $month . '"';
        }

        return $monthsSortString;
    }

//    public $fillable = [
//        'title',
//        'text',
//        'user_id',
//        'seo_id',
//        'slug',
//        'type',
//        'status',
//    ];
//
//    /**
//     * The attributes that should be casted to native types.
//     *
//     * @var array
//     */
//    protected $casts = [
//        'title' => 'string',
//        'text' => 'string',
//        'user_id' => 'integer',
//        'seo_id' => 'integer',
//        'slug' => 'string',
//        'type' => 'integer',
//        'status' => 'integer',
//    ];
//
//    /**
//     * Validation rules
//     *
//     * @var array
//     */
//    public static $rules = [
//        'title' => 'required|max:255',
//        'text' => 'required',
//        'status' => 'required',
//    ];
}
