@extends('admin.layout.blank')
@section('content')
    <div class="h-100 bg-cover bg-center py-5 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-4 mx-auto">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="mb-5 text-center">
                                <img src="{{ asset('img/image/logo-2.png') }}" class="mw-100 mb-4" height="80">
                                <p>{{ translate('Login to your account.') }}</p>
                            </div>
                            <form class="pad-hor" method="POST" role="form">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email"
                                        class="form-control{{ session('error') && $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        value="{{ old('email') }}" required autofocus
                                        placeholder="{{ translate('Email') }}">
                                    @if (session('error') && $errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password"
                                        class="form-control{{ session('error') && $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required placeholder="{{ translate('Password') }}">
                                    @if (session('error') && $errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <div class="text-left">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="remember" id="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <span>{{ translate('Remember Me') }}</span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{ translate('Login') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
