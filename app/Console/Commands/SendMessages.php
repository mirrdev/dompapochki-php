<?php

namespace App\Console\Commands;

use App\Http\Models\SenderQueries;
use Illuminate\Console\Command;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
    }
}
