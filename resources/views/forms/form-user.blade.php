@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.user.create')</h1>
                <ul>
                    <li><a href="{{route('users')}}">@lang('panel.user.header')</a></li>
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
                                    <!-- Name Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="name">@lang('panel.user.name')</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="@lang('panel.user.name')" value="{{$item->name}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="email">@lang('panel.user.email')</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="@lang('panel.user.email')" value="{{$item->email}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="name">@lang('panel.user.password')</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="@lang('panel.user.password')" value="">
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
