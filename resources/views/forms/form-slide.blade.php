@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.slide.create')</h1>
                <ul>
                    <li><a href="{{route('slides')}}">@lang('panel.slide.header')</a></li>
                    <li>@lang('panel.create')</li>
                </ul>
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Заполните все обязательные поля</div>
                            <form class="needs-validation" novalidate method="post" action="{{$route}}">
                                @csrf
                                <div class="form-row mb-2">

                                    <!-- Filepath Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="name">@lang('panel.slide.fields.filepath')</label>
                                        <div>
                                            <button data-input="thumbnail" data-preview="holder" class="btn btn-primary upload-btn">
                                               <i class="fa fa-picture-o"></i> @lang('panel.select.image')
                                            </button>
                                        </div>
                                        <input id="thumbnail" type="hidden" class="form-control" name="filepath" id="filepath" placeholder="@lang('panel.slide.fields.filepath')" value="{{$item->filepath}}" required>
                                        <div id="holder" style="margin-top:15px;max-height:100px;">
                                            @if(isset($item->filepath))
                                                <img height="100px" src="{{$item->filepath}}"/>
                                            @endif
                                        </div>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Order Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="order">@lang('panel.nav.order')</label>
                                        <input type="number" class="form-control" name="order" id="order" placeholder="@lang('panel.nav.order')" value="{{$item->order}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.slide.fields.status.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=1 formcontrolname="radio" @if($item->status == 1) checked @endif>
                                            <span>@lang('panel.slide.fields.status.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=0 formcontrolname="radio" @if($item->status == 0) checked @endif>
                                            <span>@lang('panel.slide.fields.status.off')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                </div>
                                <button class="btn btn-primary" type="submit">@lang('panel.save')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('page-js')


@endsection

@section('bottom-js')

 <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
 <script>$('.upload-btn').filemanager('slide');</script>

@endsection
