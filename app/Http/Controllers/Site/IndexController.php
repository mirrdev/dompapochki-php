<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Settings;
use App\Http\Models\Slide;
use App\Http\Models\SenderQueries;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index()
    {
        $settings = Settings::getFromHomepage();
        $categories = Category::getAllShownOnTheHomepage();
        $slides = Slide::getAllShownOnTheHomepage();
        $seo = [
            'title' => 'Дом Папочки (La Casa di Pappa) - осетинские пироги',
            'description' => 'Доставка осетинских пирогов Минск, доставка пирогов, осетинские пироги минск, доставка пиццы минск, пицца минск, доставка пиццы быстро'
        ];
        $data = [
            'settings' => $settings,
            'categories' => $categories,
            'slides' => $slides,
            'seo' => $seo
        ];
        return view('site/index', $data);
    }
    
    public function sendercommandstart()
    {
        // \Artisan::call('send:messages');
        $limit = (int) env('SENDER_LIMIT');
        $date = date('Y-m-d H:i:s', time());

        //выбрать из очереди не отправленных SENDER_LIMIT штук
        foreach (SenderQueries::getLast($limit) as $item)
        {
            //отправить соглассно типу
            switch ($item->type)
            {
                //телеграм
                case SenderQueries::TELEGRAM : {
                    SenderQueries::sendTelegram($item->data);
                    $item->send_at = $date;
                    $item->status = SenderQueries::STATUS_SEND;
                    $item->save();
                    break;
                }
                //коллцентр
                case SenderQueries::CALLCENTR : {
                    SenderQueries::sendCallCenter($item->data);
                    $item->send_at = $date;
                    $item->status = SenderQueries::STATUS_SEND;
                    $item->save();
                    break;
                }
                //e-mail
                case SenderQueries::EMAIL : {
                    $data = json_decode($item->data, true);
                    SenderQueries::sendEmail($data);
                    $item->send_at = $date;
                    $item->status = SenderQueries::STATUS_SEND;
                    $item->save();
                    break;
                }
            }
        }
        echo $limit;
        exit();
    }
}
