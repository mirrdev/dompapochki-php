<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\Mail;

/**
 * Class SenderQueries
 * @package App\Http\Models
 * @version February 01, 2019, 11:24 am UTC
 *
 * @property string data
 * @property string send_at
 * @property integer status
 * @property integer type
 */
class SenderQueries extends Model
{

    public $table = 'sender_queries';

    public const EMAIL              = 0;
    public const TELEGRAM           = 1;
    public const CALLCENTR          = 2;

    public const STATUS_NOT_SEND    = 0;
    public const STATUS_SEND        = 1;


    public $fillable = [
        'data',
        'send_at',
        'status',
        'type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'string',
        'send_at' => 'string',
        'type' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'data' => 'required',
        'status' => 'required',
        'type' => 'required',
    ];

    public static function getLast($limit = 5)
    {
        $items = self::where('status', '=', self::STATUS_NOT_SEND)->take($limit)->get();
        return $items;
    }

    public static function sendCallCenter($url)
    {
        $mych = curl_init();
        curl_setopt($mych, CURLOPT_URL, $url);
        curl_setopt($mych, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($mych, CURLOPT_HEADER, 0);
        curl_exec($mych);
        curl_close($mych);
    }
    public static function sendTelegram($message)
    {
        $token = env('TELEGRAM_TOKEN');
        $chat_id = env('TELEGRAM_CHAT_ID');

        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . $token . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => $chat_id,
                    'text' => $message,
                    'parse_mode' => 'markdown'
                ),
            )
        );
        curl_exec($ch);
    }
    public static function sendEmail($item)
    {
        Mail::send(
            'mail.order',
            ['text' => $item['message']],
            function ($message) use ($item) {
                $email = preg_replace('/\s+/', '', $item['recipient']);
                $message->to($item['recipient'], 'dompapochki.by')->subject($item['subject']);
                $message->from(env('MAIL_FROM_ADDRESS'), 'Dom papochki');
            }
        );
//        Mail::raw(
//            $item['message'],
//            function ($message) use ($item) {
//                $message->to($item['recipient'], 'dompapochki.by')->subject($item['subject']);
//                $message->from(env('MAIL_FROM_ADDRESS'), 'Dom papochki');
//            }
//        );
    }
}
