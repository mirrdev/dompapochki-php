<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use App\Http\Models\Product;
use App\Http\Models\SenderQueries;
use BeGateway\GetPaymentToken;
use BeGateway\Logger;
use BeGateway\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $data = [
            'cart' => ['text' => '']
        ];
        return view('site/cart', $data);
    }

    public function pay(Request $request)
    {
        if ($request->isMethod('post')) {

            $input = $request->only(['products', 'name', 'phone', 'delivery', 'payment', 'street', 'home', 'home1', 'home2', 'home3', 'flat', 'message', 'time', 'date', 'promocode']);
            $activeDiscount = false;
            $enablePromoCode = \App\Http\Models\Settings::getValue('cart_promo_code_show');
            $deliveryType = (int) $input['delivery'];

            if ($enablePromoCode === '1') {
                $activeDiscount = (int) $input['delivery'] === 0 ? true : $this->isValidPromoCode($input['promocode']);
            }
            list($cart, $price, $cartArray, $urlParams) = $this->getCartAndPrice($input['products'], $activeDiscount, $deliveryType);
            $deliveryInfo = self::getDeliveryInfo($input);

            $order = new Order();
            $order->name = $input['name'];
            $order->phone = $input['phone'];
            $order->street = $input['street'];
            $order->home = $input['home'];
            $order->home_korpus = $input['home1'];
            $order->home_podezd = $input['home2'];
            $order->home_etaj = $input['home3'];
            $order->flat = $input['flat'];
            $input['home3'] . '-' . $input['flat'];
            $order->message = (isset($input['message'])) ? $input['message'] : '-';
            $order->delivery_time = $input['date'] . "|" . $input['time'];
            $order->delivery_info = $deliveryInfo;
            $order->cart = $cart;
            $order->price = $price;

            //проверка онлайн или нет оплата
            $order->status = ($input['payment'] == 2) ? Order::STATUS_PAY_PROGRESS : Order::STATUS_NEW;
            $order->hash = Str::random(50);

            $order->delivery_type = $input['delivery'];
            $order->payment_type = $input['payment'];

            if($order->save())
            {
                $this->addMessageEmail($order);
                $this->addMessageCallCenter($urlParams, $request, $order['id']);
                $this->addMessageTelegram($cart, $deliveryInfo);
                $this->addMessageCurl($order, $cartArray, $order['id']);

                if($order->status == Order::STATUS_PAY_PROGRESS){
                    return redirect(route('cart-payment', ['hash' => $order->hash]));
                }
                else{
                    return redirect(route('cart-finish', ['hash' => $order->hash]));
                }
            }
        }
    }
    public function finish($hash)
    {
        $order = Order::where('hash', '=', $hash)->orderBy('id', 'desc')->first();

        if(!is_null($order))
        {
            $data = [
                'order' => $order
            ];
            return view('site/delivery', $data);
        }

        return abort(404);
    }
    public function payment($hash)
    {
        $model = Order::where('hash', '=', $hash)->orderBy('id', 'desc')->first();

        if(!is_null($model))
        {
            if($model['bepaid_token'] == '' && !$model['bepaid_uid']){

                Settings::$shopId  = env('ACQUIRE_ID');
                Settings::$shopKey = env('ACQUIRE_KEY');
                Settings::$checkoutBase = env('ACQUIRE_URL_CHECKOUT');
                Settings::$gatewayBase = env('ACQUIRE_URL_GATEWAY');
                Settings::$apiBase = env('ACQUIRE_URL_API');

//            Settings::$shopId  = 361;
//            Settings::$shopKey = 'b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d';

                Logger::getInstance()->setLogLevel(Logger::INFO);

                $transaction = new GetPaymentToken();

                $transaction->money->setAmount($model['price']);
                $transaction->money->setCurrency('BYN');
                $transaction->setDescription(strip_tags(iconv_substr ($model["cart"], 0 , 240 , "UTF-8")).'...');
                $transaction->setTrackingId($model['id']);

                $transaction->setLanguage('ru');
                $transaction->setNotificationUrl(env('ACQUIRE_URL_NOTIFICATIONS'));
                $transaction->setSuccessUrl(env('ACQUIRE_URL_SUCCESS'));
                $transaction->setDeclineUrl(env('ACQUIRE_URL_DECLINE'));
                $transaction->setFailUrl(env('ACQUIRE_URL_FAIL'));
                $transaction->setCancelUrl(env('ACQUIRE_URL_CANCEL'));

                $transaction->customer->setFirstName($model['name']);
                $transaction->customer->setLastName($model['name']);
                $transaction->customer->setIp(\Illuminate\Support\Facades\Request::ip());
                $transaction->customer->setCountry('BY');
                $transaction->customer->setAddress($model['delivery_info']);
                $transaction->customer->setCity('Minsk');
                $transaction->customer->setZip('222640');
                $transaction->customer->setEmail('order@dompapochki.by');
//            $transaction->customer->setPhone($model['phone']);

                $response = $transaction->submit();

                $model['bepaid_token'] = $response->getToken();


                if ($model->save() && $response->isSuccess() ) {
                    header("Location: " . $response->getRedirectUrl() );
                }
            }
        }
        else
        {
            return abort(404);
        }
    }

    private function getCartAndPrice($productsInput, $enableDiscount, $deliveryType)
    {

        $promoShow = \App\Http\Models\Settings::getValue('cart_promo_code_show');
        $promoValue = \App\Http\Models\Settings::getValue('cart_promo_code');
        $promoSum = \App\Http\Models\Settings::getValue('cart_discount_sum');
        $excludeCategoryId = (int) \App\Http\Models\Settings::getValue('exclude_category_id');
        $promoPersent = \App\Http\Models\Settings::getValue('cart_discount_amount');

        $products = [];
        $productsIds = [];
        foreach ($productsInput as $k=>$product)
        {
            $id = str_replace('prod_','', $k);
            $productsIds[] = $id;

            foreach ($product as $kk=>$type)
            {
                $products[] = [
                    'id' => $id,
                    'type' => str_replace('type_','', $kk),
                    'count' => $type
                ];
            }
        }
        $productsItems = Product::whereIn('id', $productsIds)->get();
        $cart = '';
        $cartArray = [];
        $urlParams = '';
        $price = 0.0;
        $sumDiscont = 0.0;
        $ink = 0;

        foreach ($products as $product)
        {
            foreach ($productsItems as $item)
            {
                if($product['id'] == $item->id){
                    $priceId = 'price' . $product['type'];
                    $detailId = 'detail' . $product['type'];
                    $nameId = 'name' . $product['type'];
                    $id = $item->id;

                    $typePrice = $item[$priceId];
                    $count = (int) $product['count'];
                    if ($enableDiscount) {
                        $discont = $excludeCategoryId === $item->category->id
                        ? 0
                        : round(($typePrice * $count === 0 ? 1 : $typePrice * $count) / 100 * $promoPersent, 2);
                    } else {
                    $discont = 0;
                    }
                    $sum = $typePrice * $count;
                    $price = $price + $sum;
                    $sumDiscont = $sumDiscont + $discont;
                    $category = $item->category->title;
                    $productTitle = $item->title;
                    $detail = $item[$detailId];
                    $typeName = $item[$nameId];

                    $cartCurrent = ['category' => $category, 'productTitle' => $productTitle, 'typeName' => $typeName, 'count' => $count,'typePrice' => $typePrice];
                    array_push($cartArray, $cartCurrent);
                    $cart .= "<p><b>$category $productTitle</b> ( $count шт ) <b>$typeName $detail </b>  $typePrice руб x $count = $sum руб</p><p>";

                    $newType = 100 * $product['type'];
                    $idTypeProduct = "$newType$id";
                    $urlParams .= "&articles[".$ink."]=".$idTypeProduct."&quantities[".$ink."]=".$count; $ink++;
                }
            }
        }
        if ($enableDiscount) {
            if ($deliveryType === 0) {
                $cart .= "<p><b>Скидка: </b>  $sumDiscont руб</p><p>";
            } else if ($deliveryType === 1 && $price >= $promoSum) {
                $cart .= "<p><b>Скидка: </b>  $sumDiscont руб</p><p>";
            }
        }
        if ($price > 0) {
            if ($enableDiscount){
                if ($deliveryType === 0) {
                    $price = $price - $sumDiscont;
                } else if ($deliveryType === 1 && $price >= $promoSum) {
                    $price = $price - $sumDiscont;
                }
            }
            $cart .= "<p><b>ИТОГО: </b>  $price  руб</p><p>";
        }
        return [$cart, $price, $cartArray, $urlParams];

    }
    private function getDeliveryInfo($input){
        switch ($input['payment']){
            case 0: $money = "наличными "; break;
            case 1: $money = "картой "; break;
            case 2: $money = "оплата онлайн "; break;
            case 3: $money = "ЕРИП"; break;
            default: $money = "наличными "; break;
        }
        switch ($input['delivery']){
            case 1:{
                    $deliveryInfo = "УЛИЦА: " . $input['street'] . " | ДОМ: " . $input['home'] . " | КОРПУС: " . $input['home1'] . " | КВАРТИРА: " . $input['flat'] . " | ПОДЪЕЗД: " . $input['home2'] . " | ЭТАЖ: " . $input['home3'] . " | ДОСТАВИТЬ К: " . $input['date'] . " | " . $input['time'];
                    break;
                }
            case 0:
            default:{
                    $deliveryInfo = "САМОВЫВОЗ | ПРИГОТОВИТЬ К: " . $input['date'] . " | " . $input['time'];
                    break;
                }
        }

        return "ОПЛАТА: " . $money  .  " | " . $deliveryInfo;

    }

    private function isValidPromoCode($currentValue) {
        $promoShow = \App\Http\Models\Settings::getValue('cart_promo_code_show');
        $promoValue = \App\Http\Models\Settings::getValue('cart_promo_code');
        $promoSum = \App\Http\Models\Settings::getValue('cart_discount_sum');
        if (!$promoShow || !$promoValue || !$promoSum) {
            return false;
        }
        return mb_strtolower(preg_replace('/\s+/', '', $currentValue)) === mb_strtolower(preg_replace('/\s+/', '', $promoValue));
    }

    private function addMessageCallCenter($urlParams, $request, $idOrder)
    {
        $url = env('SEND_CALL_CENTER_URL');
        $url.="?";
        $url.="user=shop";
        $url.="&password=Qwert123";
        $url.="&wid=8656";
	    $url.="&saleChannel=3512968801242745208";

        $url.="&family=".urlencode($request['name']);
        $url.="&street=".urlencode($request['street']);
        $url.="&building=".urlencode($request['home1']);
        $url.="&home=".urlencode($request['home']);
        $url.="&room=".urlencode($request['flat']);
        $url.="&comment=".urlencode($request['message']);
        $url.="&phone=".urlencode($request['phone']);
        $url.="&entrance=".urlencode($request['home2']);
        $url.="&floor=".urlencode($request['home3']);
        $url.="&webId=".urlencode($idOrder);
        if($request['money'] !== 0)
        {
            $url .= "&nonCash=".urlencode('card_or_online');
        }

        $url .= $urlParams;

        $message = new SenderQueries();
        $message->data = $url;
        $message->type = SenderQueries::CALLCENTR;
        $message->status = SenderQueries::STATUS_NOT_SEND;

        $message->save();
    }

    private function addMessageCurl($order, $cartArray, $idOrder)
    {
        // $orderArray = ['idOrder'=>$idOrder, 'name' => $order->name, 'phone' =>  $order->phone, 'cartArray' => $cartArray, 'delivery_type' => $order->delivery_type, 'payment_type' => $order->payment_type, 'delivery_info' => $order->delivery_info, 'price' => $order->price]; //массив данных заказа
        // $HTMLmessage = '<p>'.$order->name.'</p><p>'.$order->phone.'</p><p>'.$order->delivery_info .'</p><p>'.$order->message.'</p>'.$order->cart; //текстовое сообщение, то которое сейчас попочте отправляется
        // $NK_order = ['data'=>$orderArray,'html_message'=>$HTMLmessage];   // формируем данные для отправки в контакт центр
        // $NK_username = 'dompapochkiAPI';
        // $NK_password = '4ifnsks';
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,"https://my.virtual-office.by:20443/dom_papochki/mailchecker/api.php?method=addUnconfirmedCall"); // url где находится API
        // curl_setopt($ch, CURLOPT_USERPWD, $NK_username . ":" . $NK_password);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($NK_order) );
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        // $NK_result_json = curl_exec($ch);
        // curl_close($ch);
        // $NK_result = json_decode($NK_result_json);
        // if(!$NK_result->result) {
        //     mail('n.nikolaenko@c-c.by','dom_papochki API error',$NK_result_json);
        // }  // если ответ не положительный - сообщаем об этом по почте администратору коллцентра и отправляем полученный ответ

    }

    private function addMessageTelegram($order, $address)
    {
        $text = '**ЗАКАЗ С САЙТА:**' . PHP_EOL . PHP_EOL;
        $text .= '`' . $order . PHP_EOL . '`' .PHP_EOL;
        $text .= '==================================================' . PHP_EOL. PHP_EOL;
        $text .= $address;
        $text = str_replace(' |', PHP_EOL, $text);
        $text = str_replace('- -', '', $text);
        $text = str_replace('<p>', '', $text);
        $text = str_replace('</p>', '' . PHP_EOL, $text);
        $text = str_replace('<b>', '', $text);
        $text = str_replace('</b>', '' . PHP_EOL, $text);
        $text = str_replace('<span style="color: red">', '', $text);
        $text = str_replace('</span>', '', $text);

        $message = new SenderQueries();
        $message->data = $text;
        $message->type = SenderQueries::TELEGRAM;
        $message->status = SenderQueries::STATUS_NOT_SEND;

        $message->save();
    }
    private function addMessageEmail($order)
    {
        $cart = '<p>'.$order->name.'</p><p>'.$order->phone.'</p><p>'.$order->delivery_info .'</p><p>'.$order->message.'</p>'.$order->cart;
        $emails = explode(',',\App\Http\Models\Settings::getValue('emails'));
        $subject = trans('panel.email.messages.order.subject');

        foreach ($emails as $email) {
            $data = [
                'subject' => $subject,
                'message' => $cart,
                'recipient' => preg_replace('/\s+/', '', $email)
            ];

            $message = new SenderQueries();
            $message->data = json_encode($data);
            $message->type = SenderQueries::EMAIL;
            $message->status = SenderQueries::STATUS_NOT_SEND;
            $message->save();
        }
    }
}
