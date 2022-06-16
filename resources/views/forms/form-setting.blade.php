@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.settings.create')</h1>
                <ul>
                    <li><a href="{{route('settings')}}">@lang('panel.settings.header')</a></li>
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
                                        <label for="title">@lang('panel.settings.title')</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('panel.settings.title')" value="{{$item->title}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    @if(!empty($item->type) || !is_null($item->type))
                                        <!-- Value Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="text">@lang('panel.settings.value')</label><br>
                                            @switch($item->type)
                                                @case(\App\Http\Models\Settings::STRING)
                                                <input type="text" class="form-control" name="value" id="value" value="{{$item->value}}" placeholder="@lang('panel.settings.value')" required/>
                                                @break
                                                @case(\App\Http\Models\Settings::EDITOR)
                                                <textarea type="text" class="form-control editor" name="value" id="value" placeholder="@lang('panel.settings.value')" required>{{$item->value}}</textarea>
                                                @break
                                                @case(\App\Http\Models\Settings::TEXTAREA)
                                                <textarea type="text" class="form-control" name="value" id="value" placeholder="@lang('panel.settings.value')" required>{{$item->value}}</textarea>
                                                @break
                                                @case(\App\Http\Models\Settings::INTEGER)
                                                <input type="number" class="form-control" name="value" id="value" value="{{$item->value}}" placeholder="@lang('panel.settings.value')" required/>
                                                @break
                                                @case(\App\Http\Models\Settings::SWITCHER)
                                                <label class="radio radio-primary">
                                                    <input type="radio" name="value" value="1" [value]="1" formControlName="radio" @if($item->value == 1) checked @endif>
                                                    <span>@lang('panel.select.switch.on')</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio radio-primary">
                                                    <input type="radio" name="value" value="0" [value]="0" formControlName="radio" @if($item->value == 0) checked @endif>
                                                    <span>@lang('panel.select.switch.off')</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                @break
                                            @endswitch
                                            <div class="valid-tooltip">
                                                @lang('panel.message.valid')
                                            </div>
                                            <div class="invalid-tooltip">
                                                @lang('panel.message.invalid')
                                            </div>
                                        </div>
                                    @else

                                        <!-- Key Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="text">@lang('panel.settings.key')</label>
                                            <input type="text" class="form-control" name="key" id="key" placeholder="@lang('panel.settings.title')" value="{{$item->key}}" required>
                                            <div class="valid-tooltip">
                                                @lang('panel.message.valid')
                                            </div>
                                            <div class="invalid-tooltip">
                                                @lang('panel.message.invalid')
                                            </div>
                                        </div>

                                        @php($types = \App\Http\Models\Settings::getTypes())
                                        <!-- Type Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="text">@lang('panel.settings.type')</label>
                                            <select name="type" class="form-control">
                                                @foreach($types as $type)
                                                    <option <?= ($type['id'] == $item->type)?'selected = "selected"':'' ?> value = "{{$type['id']}}">{{$type['name']}}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-tooltip">
                                                @lang('panel.message.valid')
                                            </div>
                                            <div class="invalid-tooltip">
                                                @lang('panel.message.invalid')
                                            </div>
                                        </div>
                                    @endif
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
