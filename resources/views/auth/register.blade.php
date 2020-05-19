@extends('layouts.app')

@section('content')
<div class="row" style="position: relative; top: 100px;">
    <div class="col-lg-4 col-md-offset-4">
        <h1 style="margin-bottom: 25px; font-family: Arvo; font-size: 24px; font-weight: 600; color: #666666; ">ثبت نام </h1>
        <form role="form" method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="account-email" class="control-label"><span class="glyphicon glyphicon-envelope" aria-hidden="true" style="padding-right: 5px;"></span> ایمیل</label>
                <input id="account-email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="user-name" class="control-label"><span class="glyphicon glyphicon-user" aria-hidden="true" style="padding-right: 5px;"></span> نام</label>
                <input type="text" id="user-name" class="form-control" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="account-password" class="control-label"><span class="glyphicon glyphicon-lock" aria-hidden="true" style="padding-right: 5px;"></span> رمز عبور</label>
                <input type="password" id="account-password" class="form-control" name="password">
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="account-repassword" class="control-label"><span class="glyphicon glyphicon-lock" aria-hidden="true" style="padding-right: 5px;"></span> تکرار رمز عبور</label>
                <input type="password" id="account-repassword" class="form-control" name="password_confirmation">
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> ثبت نام
                </button>
            </div>
            <div class="form-group">
                اگر حساب دارید و قبلا ساختید لاگین کنید? <a href="{{ url('/login') }}"><u>ورود به حساب</u>.</a>
            </div>
        </form>
    </div>
</div>
</div>
@endsection