@extends('layouts.site')
@section('title', $seo->title)
@section('description',$seo->description)
@section('main-content')

    <div class="row">
		<div class="col-md-12">
			<h1 class="text-danger">{{$page['title']}}</h1>
			{!! $page['text'] !!}
		</div>
	</div>
	
    @php($deliveryTitle = \App\Http\Models\Settings::getValue('homepage_delivery_title'))
    @php($deliveryMap = \App\Http\Models\Settings::getValue('homepage_delivery_map'))
    
	@if(isset($deliveryTitle) && $page['id'] == 9)
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-danger">{{$deliveryTitle}}</h3>
				{!! $deliveryMap !!}
			</div>
		</div>
	@endif

@endsection
