@extends('layouts.site')
@section('title', $seo->title)
@section('description',$seo->description)
@section('main-content')

	<hr>
    <div class="row">
		<div class="col-md-12">
			<h1 class="text-danger text-uppercase">{{$category['title']}}</h1>
		</div>
	</div>

	@if(isset($products) && count($products) > 0)
		<div class="row">
			@foreach($products as $product)
				<div class="col-md-12 mb-5">
					<div class="row product">
                        <div class="col-lg-6 col-xl-6">
							<div class="product-img">
								<a href="{{route('product', $product->slug)}}">
									<img class="photo rounded d-block" width="100%" alt="{{$product->title}}" src="{{$product->filepath}}">
								</a>
							</div>
						</div>
                        <div class="col-lg-6 col-xl-6">
                            <div class="product-content">
                                <h4 class="product-title mt-lg-2">
									<a href="{{route('product', $product->slug)}}">
										<span class="text-success text-uppercase">{{$product->title}}</span>
										@if($product->label == \App\Http\Models\Product::LABEL_POPULAR)
											<sup class="badge bg-danger">@lang('panel.product.fields.label.popular')</sup>
										@endif
										@if($product->label == \App\Http\Models\Product::LABEL_HOT)
											<sup class="badge bg-danger">@lang('panel.product.fields.label.hot')</sup>
										@endif
									</a>
								</h4>
                                <p>{{$product->description}}</p>
                                <?php for($i=1;$i<=3;$i++)if($product['detail'.$i] && $product['price'.$i]){
                                $first = $i;
                                ?>

								<div class="row mb-1 align-items-center">
									<div class="col-sm-6">
										<div class="mb-2"><strong>{{$product['name'.$i]}}</strong></div>
										{{$product['detail'.$i]}} - {{$product['price'.$i]}} руб
									</div>
									<div class="col-sm-6">
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
			@endforeach
		</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			{!! $category['text'] !!}
		</div>
	</div>

@endsection
