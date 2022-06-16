@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.pages.create')</h1>
                <ul>
                    <li><a href="{{route('pages')}}">@lang('panel.pages.header')</a></li>
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
                                    <!-- Title Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="title">@lang('panel.pages.title')</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('panel.pages.title')" value="{{$item->title}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Slug Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="title">@lang('panel.pages.slug')</label>
                                        <input type="text" class="form-control" name="slug" id="slug" placeholder="@lang('panel.pages.slug')" value="{{$item->slug}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Text Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.pages.text')</label>
                                        <textarea type="text" class="form-control editor" name="text" id="text" placeholder="@lang('panel.pages.text')" required>{{$item->text}}</textarea>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.pages.status.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=1 formcontrolname="radio" @if($item->status == 1) checked @endif>
                                            <span>@lang('panel.pages.status.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=0 formcontrolname="radio" @if($item->status == 0) checked @endif>
                                            <span>@lang('panel.pages.status.off')</span>
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
                                <div class="form-row">
                                    <label for="title">@lang('panel.seo.header')</label>
                                    <!-- SEO Title Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="titleSEO">@lang('panel.seo.title')</label>
                                        <input type="text" class="form-control" id="titleSEO" name="seo[title]" placeholder="@lang('panel.seo.title')" value="{{$seo->title}}">
                                    </div>
                                    <!-- SEO Description Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="textSEO">@lang('panel.seo.description')</label>
                                        <textarea class="form-control" id="textSEO" name="seo[description]" placeholder="@lang('panel.seo.description')">{{$seo->description}}</textarea>
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


@endsection
