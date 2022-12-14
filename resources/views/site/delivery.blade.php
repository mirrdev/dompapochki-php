@extends('layouts.site')
@section('title', trans('panel.delivery.title'))
@section('description','')
@section('main-content')

<div class="row text-center cart-end">
    <div class="col-md-12">
        <h1 class="text-danger">@lang('panel.delivery.number'): {!! $order->id !!}</h1>
        @if($order->payment_type === 3)
            @include('layouts.erip')
        @endif
        <p><b>@lang('panel.delivery.description')</b></p>
        <br>
        <p>@lang('panel.delivery.order'):</p>
        {!! $order->cart !!}
    </div>
</div>

@endsection
