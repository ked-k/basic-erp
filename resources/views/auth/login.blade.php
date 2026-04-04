@extends('layouts.auth')
@php
    use App\Models\Utility;
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $settings = Utility::settings();
    $company_logo = $settings['company_logo'] ?? '';
@endphp

@push('custom-scripts')
    @if ($settings['recaptcha_module'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush

@section('page-title')
    {{ __('Login') }}
@endsection

@if ($settings['cust_darklayout'] == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
@endif

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti ti-check-circle me-2"></i>
                <span>{{ session('status') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{ Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm', 'class' => 'login-form needs-validation', 'novalidate']) }}
        <div class="form-group mb-4">
            <label class="form-label fw-600">{{ __('Email Address') }}</label>
            {{ Form::text('email', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('name@example.com'), 'required' => 'required', 'autocomplete' => 'email']) }}
            @error('email')
                <div class="invalid-feedback d-block mt-2">
                    <i class="ti ti-alert-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label fw-600">{{ __('Password') }}</label>
            {{ Form::password('password', ['class' => 'form-control form-control-lg', 'placeholder' => __('••••••••'), 'id' => 'input-password', 'required' => 'required', 'autocomplete' => 'current-password']) }}
            @error('password')
                <div class="invalid-feedback d-block mt-2">
                    <i class="ti ti-alert-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                {{ Form::checkbox('remember', true, null, ['class' => 'form-check-input', 'id' => 'rememberMe']) }}
                <label class="form-check-label" for="rememberMe">
                    {{ __('Remember me') }}
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request', $lang) }}" class="forgot-password-link">{{ __('Forgot password?') }}</a>
            @endif
        </div>

        @if ($settings['recaptcha_module'] == 'on')
            @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2-checkbox')
                <div class="form-group mb-4">
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <div class="small text-danger mt-2">
                            <i class="ti ti-alert-circle me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            @else
                <div class="form-group d-none">
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" class="form-control">
                    @error('g-recaptcha-response')
                        <div class="small text-danger mt-2">
                            <i class="ti ti-alert-circle me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif
        @endif

        <div class="d-grid gap-2 mb-4">
            {{ Form::submit(__('Sign In'), ['class' => 'btn btn-primary btn-lg fw-600', 'id' => 'saveBtn']) }}
        </div>

        @if ($settings['enable_signup'] == 'on')
            <div class="text-center">
                <p class="mb-0">{{ __("Don't have an account?") }}
                    <a href="{{ route('register', ['0',$lang]) }}" class="signup-link fw-600">{{ __('Create Account') }}</a>
                </p>
            </div>
        @endif
    {{ Form::close() }}
@endsection

<script src="{{ asset('js/jquery.min.js') }}"></script>
@if (isset($settings['recaptcha_module']) && $settings['recaptcha_module'] == 'on')
    @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2-checkbox')
        {!! NoCaptcha::renderJs() !!}
    @else
        <script src="https://www.google.com/recaptcha/api.js?render={{ $settings['google_recaptcha_key'] }}"></script>
        <script>
            $(document).ready(function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ $settings['google_recaptcha_key'] }}', {
                        action: 'submit'
                    }).then(function(token) {
                        $('#g-recaptcha-response').val(token);
                    });
                });
            });
        </script>
    @endif
@endif
