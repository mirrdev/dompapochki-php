@extends('layouts.site')
@section('title', $seo->title)
@section('description',$seo->description)
@section('main-content')

	<hr>
    <div class="row">
		<div class="col-md-12">
			<h1 class="text-danger">{{$page['title']}}</h1>
			{!! $page['text'] !!}
		</div>
	</div>

	@if(isset($settings['homepage_delivery_map']))
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-danger">{{$settings['homepage_delivery_title']}}</h3>
				{!! $settings['homepage_delivery_map'] !!}
			</div>
		</div>
	@endif

@endsection