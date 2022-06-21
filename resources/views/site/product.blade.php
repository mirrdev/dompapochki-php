@extends('layouts.site')
@section('title', $seo->title)
@section('description',$seo->description)
@section('main-content')

    <div class="row">
		<div class="col-md-12">
			<h1 class="text-danger text-uppercase">{{$product['title']}}</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 mb-5">
			<div class="row product-preview-big">
				<div class="col-lg-5 col-xl-5">
					<img class="product photo rounded d-block" width="100%" alt="{{$product->title}}" src="{{$product->filepath}}">
				</div>
				<div class="product-content col-lg-7 col-xl-7">
					<div class="product-content-inner">
						<p>{{$product->description}}</p>
						<?php for($i=1;$i<=3;$i++)if($product['detail'.$i] && $product['price'.$i]){
						$first = $i;
						?>

						<div class="row mb-1 align-items-center">
							<div class="col-sm-6 col-lg-6">
								<div class="mb-2"><strong>{{$product['name'.$i]}}</strong></div>
								{{$product['detail'.$i]}} - {{$product['price'.$i]}} руб
							</div>
							<div class="col-sm-6 col-lg-6">
								<a href="#0" class="cd-add-to-cart btn btn-outline-success"
								   data-title="{{$product->title}}"
								   data-id="{{$product->id}}"
								   data-price="{{$product['price'.$i]}}"
								   data-type="{{$i}}"
								   data-detail="{{$product['name'.$i]}} - {{$product['detail'.$i]}}"
								   data-url="{{route('product', ['slug' => $product->slug])}}"
								   data-img="{{$product->filepath}}"
								   data-category="{{$product->category_id}}"
								   data-count=1
								>добавить в корзину</a>

							</div>
						</div>

						<?php }?>
					</div>
				</div>
				<!-- .product-content -->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			{!! $product['text'] !!}
		</div>
	</div>

@endsection
