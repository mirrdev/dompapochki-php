@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{!! $data->header !!}</h1>
        @if(!is_null($data->headerActions))
            @foreach($data->headerActions as $item)
                {!! $item !!}
            @endforeach
        @endif
        @if(!is_null($data->breadcrumbs))
            <ul>
               @foreach($data->breadcrumbs as $item)
                    {!! $item !!}
                @endforeach
           </ul>
        @endif
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <!-- end of row -->

    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">

                <div class="card-body">
                    <p>{!! $data->description !!}</p>
                    <div class="table-responsive">
                        @include('grid.table')
                    </div>

                </div>
            </div>
        </div>
        <!-- end of col -->

    </div>
    <!-- end of row -->
@endsection

@section('page-js')

@endsection
