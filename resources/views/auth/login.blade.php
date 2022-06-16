@extends('layouts.sign')

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="p-4">
                <h1 class="mb-3 text-18">@lang('auth.login')</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">@lang('auth.email')</label>
                        <input id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-rounded" type="email"  value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('auth.password')</label>
                        <input id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-rounded" type="password" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button class="btn btn-rounded btn-primary btn-block mt-2">@lang('auth.login')</button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            @lang('auth.forgot')
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
