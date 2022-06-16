<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use App\Http\Models\Page;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notify()
    {
        $json = file_get_contents('php://input');
        $transaction = json_decode($json)->transaction;

        if(isset($transaction)){

            $token = $transaction->additional_data->vendor->token;
            $status = $transaction->status;
            $uid = $transaction->uid;

            $model = Order::where('bepaid_token','=',$token)->orderby('id','desc')->first();
            if(!is_null($model) && !$model->bepaid_uid && $model->bepaid_status == 0){

                switch ($status){
                    case 'successful':{
                        $model->status = Order::STATUS_PAY_SUCCESS;
                        $model->bepaid_uid = $uid;
                        $model->bepaid_status = 1;

                        if($model->save()){
                            return view('message', array('message'=>trans('messages.pay.notify.success')));
                        }
                        break;
                    }
                }
            }
            else{
                return view('message', array('message'=>trans('messages.pay.success')));
            }
        }
        else{
            return view('message', array('message'=>trans('messages.pay.notify.hacker')));
        }
    }

    public function success(Request $request)
    {
        //
    }
    public function decline(Request $request)
    {
        $id = $request->input('id');
        $model = Order::findOrFail($id);
        $model->status = Order::STATUS_PAY_CANCEL;
        if($model->save()){
            return view('message', array('message'=>trans('messages.pay.decline')));
        }
    }
    public function fail(Request $request)
    {
        $token = $request->input('token');
        $status = $request->input('status');
        $uid = $request->input('uid');

        $model = Order::where('token', '=', $token)->orderBy('id','desc')->first();
        if($model && $token && $status){
            $model->status = Order::STATUS_PAY_CANCEL;
            $model->bepaid_token = $model->bepaid_token.'error';
            if($model->save()){
                return view('message', array('message'=>trans('messages.pay.fail')));
            }
        }
    }
    public function cancel(Request $request)
    {
        $id = $request->input('id');
        $model = Order::findOrFail($id);
        $model->status = Order::STATUS_PAY_CANCEL;
        if($model->save()){
            return view('message', array('message'=>trans('messages.pay.cancel')));
        }
    }
}
