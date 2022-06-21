@extends('layouts.site')
@section('title', trans('panel.delivery.title'))
@section('description','')
@section('main-content')

    <div class="row">
		<div class="col-md-12">
			<h1 class="text-danger">@lang('panel.delivery.title')</h1>
			{!! $delivery['text'] !!}
		</div>
	</div>

@endsection
