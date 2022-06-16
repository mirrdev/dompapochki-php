@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.category.create')</h1>
                <ul>
                    <li><a href="{{route('categories')}}">@lang('panel.category.header')</a></li>
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
                                        <label for="name">@lang('panel.category.fields.title')</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('panel.category.fields.title')" value="{{$item->title}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Slug Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="title">@lang('panel.category.fields.slug')</label>
                                        <input type="text" class="form-control" name="slug" id="slug" placeholder="@lang('panel.category.fields.slug')" value="{{$item->slug}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Filepath Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="name">@lang('panel.category.fields.filepath')</label>
                                        <div>
                                            <button data-input="thumbnail" data-preview="holder" class="btn btn-primary upload-btn">
                                               <i class="fa fa-picture-o"></i> @lang('panel.select.image')
                                            </button>
                                        </div>
                                        <input id="thumbnail" type="hidden" class="form-control" name="filepath" id="filepath" placeholder="@lang('panel.category.fields.filepath')" value="{{$item->filepath}}" required>
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



                                    <!-- Text Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.category.fields.text')</label>
                                        <textarea type="text" class="form-control editor" name="text" id="text" placeholder="@lang('panel.category.fields.text')" required>{{$item->text}}</textarea>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    @php($parents = \App\Http\Models\Category::getAll())
                                    <!-- Parent Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.category.fields.parent')</label>
                                        <select name="parent_id" class="form-control">
                                            <option value = "">-</option>
                                            @foreach($parents as $parent)
                                                <option <?= ($parent['id'] == $item->parent)?'selected = "selected"':'' ?> value = "{{$parent['id']}}">{{$parent['title']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.category.fields.status.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=1 formcontrolname="radio" @if($item->status == 1) checked @endif>
                                            <span>@lang('panel.category.fields.status.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=0 formcontrolname="radio" @if($item->status == 0) checked @endif>
                                            <span>@lang('panel.category.fields.status.off')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Show on the homepage Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.category.fields.show_on_homepage.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="show_on_homepage" value=1 formcontrolname="radio" @if($item->show_on_homepage == 1) checked @endif>
                                            <span>@lang('panel.category.fields.show_on_homepage.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="show_on_homepage" value=0 formcontrolname="radio" @if($item->show_on_homepage == 0) checked @endif>
                                            <span>@lang('panel.category.fields.show_on_homepage.off')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Show in navigate Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.category.fields.show_in_navigate.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="show_in_navigate" value=1 formcontrolname="radio" @if($item->show_in_navigate == 1) checked @endif>
                                            <span>@lang('panel.category.fields.show_in_navigate.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="show_in_navigate" value=0 formcontrolname="radio" @if($item->show_in_navigate == 0) checked @endif>
                                            <span>@lang('panel.category.fields.show_in_navigate.off')</span>
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
 <script>$('.upload-btn').filemanager('category');</script>

@endsection
