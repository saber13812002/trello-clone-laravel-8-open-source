@extends('layouts.app')

@section('content')
<div class="row BYekan" style="position: relative; top: 100px;">
    <div class="col-lg-4 col-md-offset-4">

        @if(Session::has('status'))
        <div class="alert alert-success">
            <p>{{ Session::get('status') }}</p>
        </div>
        @endif

        <h1 style="margin-bottom: 25px; font-family: Byekan,Arvo; font-size: 24px; font-weight: 600; color: #666666; ">
            ورود به برنامه</h1>
        <form role="form" method="POST" action="{{ url('/login') }}">
        @csrf
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="account-email" class="control-label"><span class="glyphicon glyphicon-envelope" aria-hidden="true" style="padding-right: 5px;"></span> ایمیل شما</label>
                <input type="email" id="account-email" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="account-password" class="control-label"><span class="glyphicon glyphicon-lock" aria-hidden="true" style="padding-right: 5px;"></span>
                    رمز عبور</label>
                <input type="password" id="account-password" class="form-control" name="password">
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <input class=".radio.rtl" style="right:0px !important;" type="checkbox" name="layout" id="remember-me" value="option">
                <label for="remember-me">مرا بخاطر بسپار</label>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    ورود
                    <!-- <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> -->
                </button>
                <a class="btn btn-link" href="{{ url('password/email') }}">رمز عبورتان را فراموش کردید؟</a>
            </div>
            <div class="form-group">
                حساب ندارید؟ <a href="{{ url('/register') }}"><u>حساب جدید بسازید</u>.</a>
            </div>
        </form>
    </div>
</div>
@endsection