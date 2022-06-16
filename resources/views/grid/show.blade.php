@extends('layouts.master')

@section('main-content')

    @foreach($content as $data)
        <div class="breadcrumb">
            <h1>{!! $data->header !!}</h1>
            @if(!is_null($data->breadcrumbs))
                <ul>
                   @foreach($data->breadcrumbs as $item)
                        {!! $item !!}
                    @endforeach
               </ul>
            @endif
        </div>

        <div class="separator-breadcrumb border-top"></div>

        <div class="row mb-4">

        <div class="col-md-12">
            <div class="card text-left">

                <div class="card-body">
                    <ul class="list-group">
                        @foreach($data->cols as $k=>$col)
                            <li class="list-group-item">
                                <div><strong>{!! $col !!}</strong></div>
                                <div>{!! $data->item [$k] !!}</div>
                             </li>
                        @endforeach
                        @if(!is_null($data->item['actions']))
                            <li class="list-group-item">
                                <div><strong>@lang('panel.actions')</strong></div>
                                <div>
                                    @foreach($data->item['actions'] as $action)
                                        {!! $action !!}
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
            <!-- end of col -->

    </div>
    @endforeach

@endsection

@section('page-js')

@endsection
