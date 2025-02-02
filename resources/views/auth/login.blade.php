@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col s12 l8 xl6 offset-l2 offset-xl3">
        <div class="card">
            <div class="card-image">
                <img src="img/EC_building.jpg">
                <span class="card-title">@lang('general.login')</span>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card-content">
                    @error('email')
                    <blockquote class="error">{{ $message }}</blockquote>
                    @enderror
                    @error('password')
                    <blockquote class="error">{{ $message }}</blockquote>
                    @enderror
                    <div class="row">
                        <x-input.text id="email"    type="email"    locale="registration" required autocomplete="email" autofocus/>
                        <x-input.text id="password" type="password" locale="registration" required autocomplete="current-password"/>
                        @if (Route::has('password.request'))
                        <span class="helper-text right">
                            <a href="{{ route('password.request') }}">
                                @lang('registration.forgotpwd')
                            </a>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-action">
                    <span class="right">
                    <x-input.checkbox only_input text="registration.remember" name="remember" :checked="old('remember')??false"/>
                    </span>
                    <x-input.button only_input text="general.login"/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
