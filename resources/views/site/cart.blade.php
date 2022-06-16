@extends('layouts.site')
@section('title', trans('panel.cart.title'))
@section('description','')
@section('main-content')

<hr>

<div class="row">
	<div class="col-md-12">
		<h1 class="text-danger">@lang('panel.cart.title')</h1>
		{!! $cart['text'] !!}
	</div>
</div>

<div class="row">
	<div class="col-lg-12 cart-table">
		<form class="cart-form" action="{{route('pay')}}" method="post">
			@csrf
			<table class="table text-center">
				<thead>
					<tr>
						<th scope="col">@lang('panel.cart.table.img')</th>
						<th scope="col">@lang('panel.cart.table.title')</th>
						<th scope="col">@lang('panel.cart.table.count')</th>
						<th scope="col">@lang('panel.cart.table.price')</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
			<hr>
			<div style="">
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<strong>@lang('panel.cart.form.contacts.title')</strong>
						<input class="form-control mb-3" type="text" name="name"
							placeholder="@lang('panel.cart.form.contacts.name')" required="">
						<input class="form-control mb-3" id="phone" name="phone"
							placeholder="@lang('panel.cart.form.contacts.phone')" required="" maxlength="18">
						<textarea class="form-control mb-3" name="message"
							placeholder="@lang('panel.cart.form.contacts.comment')"></textarea>
					</div>

					<div class="col-xs-12 col-md-6 col-lg-4">
						<strong>@lang('panel.cart.form.delivery.time')</strong>
						<div class="row">
							<div class="col-sm pl-1 pr-0">
								<input placeholder="@lang('panel.cart.form.delivery.onlyDate')" type="text"
									onMouseOver="(this.type='date')" onMouseOut="(this.type='text')" id="date" name="date"
									min="@php echo date('Y-m-d'); @endphp" max="@php echo date('Y-m-d',strtotime('+1 month')); @endphp"
									value="" class="input form-control d-block">
							</div>
							<div class="col-sm pl-1">
								<select name="time" value="" class="input form-control">
									@foreach (trans('panel.cart.form.timeOfDelivery') as $key => $value)
									<option value="{{ $value }}" @if ($key==('0')) selected @endif>{{ $value }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<strong>@lang('panel.cart.form.pay.title')</strong>
						<div class="custom-control custom-radio">
							<input type="radio" id="money1" name="payment" value="0" class="custom-control-input">
							<label class="custom-control-label" for="money1">@lang('panel.cart.form.pay.cash')</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="money2" name="payment" value="1" class="custom-control-input" checked>
							<label class="custom-control-label" for="money2">@lang('panel.cart.form.pay.card')</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="money4" name="payment" value="3" class="custom-control-input">
							<label class="custom-control-label" for="money4">@lang('panel.cart.form.pay.erip')</label>
						</div>
						<div class="custom-control custom-radio mb-3">
							<input type="radio" id="money3" name="payment" value="2" class="custom-control-input">
							<label class="custom-control-label" for="money3">@lang('panel.cart.form.pay.online')</label>
						</div>

						<strong>@lang('panel.cart.form.delivery.title')</strong>
						<div class="custom-control custom-radio">
							<input type="radio" id="deliverytype1" name="delivery" value="0" class="custom-control-input" checked>
							<label class="custom-control-label" for="deliverytype1">@lang('panel.cart.form.delivery.pickup')</label>
							<div><small>{!! \App\Http\Models\Settings::getValue('footer_address') !!}</small></div>
						</div>
						<div class="custom-control custom-radio mb-3">
							<input type="radio" id="deliverytype2" name="delivery" value="1" class="custom-control-input">
							<label class="custom-control-label" for="deliverytype2">@lang('panel.cart.form.delivery.delivery')</label>
							@php($promoСodeShow = App\Http\Models\Settings::getValue('cart_promo_code_show'))
							@php($promoCodeMinSum = App\Http\Models\Settings::getValue('cart_discount_sum'))
							@php($promoCodeValue = App\Http\Models\Settings::getValue('cart_promo_code'))
							@if(isset($promoСodeShow) && !empty($promoСodeShow) && $promoСodeShow == 1)
							@php($promoCodePersent = App\Http\Models\Settings::getValue('cart_discount_amount'))
							@if(isset($promoCodePersent) && !empty($promoCodePersent))
							<div class="promo-code row mt-5" id="promocode" style="">
								<div class=" col-12">
									<strong>Введите промокод и получите скидку</strong>
								</div>
								<div class="col-8 mt-1 empty-padding">
									<input type="text" name="promocode" value="" class="form-control mb-3 px-0">
								</div>
								<div class="col-4 mt-1">
									<input type="submit" value="Применить" class="btn btn-success btn-md">
								</div>
							</div>
							@endif
							@endif
						</div>
					</div>
					<div id="address-box" class="col-xs-12 col-md-12 col-lg-4" style="display: none;">
						<strong>@lang('panel.cart.form.address.title')</strong>

						<input class="form-control mb-3" id="address" type="text" name="street"
							placeholder="@lang('panel.cart.form.address.street')">
						<input class="form-control mb-3" type="text" name="home"
							placeholder="@lang('panel.cart.form.address.house')">

						<input class="form-control mb-3" type="text" name="home1"
							placeholder="@lang('panel.cart.form.address.house3')">
						<input class="form-control mb-3" type="text" name="flat"
							placeholder="@lang('panel.cart.form.address.flat')">

						<input class="form-control mb-3" type="text" name="home2"
							placeholder="@lang('panel.cart.form.address.house2')">
						<input class="form-control mb-3" type="text" name="home3"
							placeholder="@lang('panel.cart.form.address.floor')">
					</div>
				</div>
			</div>

			<hr>
			<div class="text-right">
				<h3 class="checkout text-success mb-4">@lang('panel.cart.form.total'): <span>0</span>
					@lang('panel.cart.form.current')</h3>
				<button type="submit" class="btn btn-success btn-lg">@lang('panel.cart.form.btn')</button>
			</div>
		</form>
	</div>
</div>
<script>
	const paramCart = @json(['promoShow' => $promoСodeShow,
		'promoPersent' => $promoCodePersent,
		'promoValue' => $promoCodeValue]);
</script>
@endsection
