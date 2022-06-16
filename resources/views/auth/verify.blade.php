@extends('layouts.sign')

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('auth.verification_link_sent')
                        </div>
                    @endif

                    @lang('auth.check_verification_link')
                    @lang('auth.receive'), <a href="{{ route('verification.resend') }}">@lang('auth.request_another')</a>.
                </div>
        </div>
    </div>
@endsection
