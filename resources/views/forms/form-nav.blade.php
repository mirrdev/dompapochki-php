@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.nav.create')</h1>
                <ul>
                    <li><a href="{{route('navs')}}">@lang('panel.nav.header')</a></li>
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
                                        <label for="title">@lang('panel.nav.title')</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('panel.nav.title')" value="{{$item->title}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- URL Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="url">@lang('panel.nav.url')</label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="@lang('panel.nav.url')" value="{{$item->url}}" required>
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

                                    @php($parents = \App\Http\Models\Nav::getAll())
                                    <!-- Parent Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.nav.parent')</label>
                                        <select name="parent_id" class="form-control">
                                            <option value = "">-</option>
                                            @foreach($parents as $parent)
                                                <option <?= ($parent['id'] == $item->parent_id)?'selected = "selected"':'' ?> value = "{{$parent['id']}}">{{$parent['title']}}</option>
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
                                        <label for="text">@lang('panel.nav.status.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=1 formcontrolname="radio" @if($item->status == 1) checked @endif>
                                            <span>@lang('panel.nav.status.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=0 formcontrolname="radio" @if($item->status == 0) checked @endif>
                                            <span>@lang('panel.nav.status.off')</span>
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


@endsection
