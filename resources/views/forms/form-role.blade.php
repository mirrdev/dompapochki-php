@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.role.create')</h1>
                <ul>
                    <li><a href="{{route('roles')}}">@lang('panel.role.header')</a></li>
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
                                        <label for="name">@lang('panel.role.name')</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="@lang('panel.role.name')" value="{{$item->name}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Display name Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="display_name">@lang('panel.role.display_name')</label>
                                        <input type="text" class="form-control" name="display_name" id="display_name" placeholder="@lang('panel.role.display_name')" value="{{$item->display_name}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="description">@lang('panel.role.description')</label>
                                        <textarea class="form-control" name="description" id="description" placeholder="@lang('panel.role.description')" required>{{$item->description}}</textarea>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                    </div>

                                </div>
                                @if(isset($permissions))
                                    <div class="form-row">
                                        <label for="title">@lang('panel.permissions')</label>
                                        <!-- Permissions Title Field -->
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                        <div class="col-xs-12 col-sm-6 col-md-4 mb-3">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox" name="permissions[]" value="<?=$permission->id?>" <?=(count($permissionsRole) > 0 && in_array($permission->id, $permissionsRole)) ? ' checked' : ''?>>
                                                            <span><?=$permission->display_name?></span>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

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
