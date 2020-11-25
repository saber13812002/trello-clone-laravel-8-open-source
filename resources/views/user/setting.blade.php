@extends('layouts.app')

@section('content')
<div class="profile-con" style="padding-left: 10px !important; padding-top: 60px !important; padding-right: 10px; padding-bottom: 0px;">
    @include('layouts.partials.profileintro')
    <div class="container">
	    <div class="row" style="margin-top: 15px;">
	    	<div class="col-lg-5 col-lg-offset-3">
			    <ul class="nav nav-tabs" role="tablist" style="padding-left: 150px;">
                    <li role="presentation" @if($page=='activity') class="active" @endif>
                        <a href="{{ route('user.activity') }}"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span> {{ trans('board.Activity') }}</a>
                    </li>
                    <li role="presentation" @if($page=='profile') class="active" @endif>
                        <a href="{{ route('user.profile') }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{ trans('board.Profile') }}</a>
                    </li>
                    <li role="presentation" @if($page=='setting') class="active" @endif>
                        <a href="{{ route('user.setting') }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{ trans('board.Setting') }}</a>
                    </li>
                </ul>
	    	</div>
	    </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-5 col-lg-offset-3">
                <form action="" method="POST" role="form">
                @csrf
                    <div class="form-group">
                        <label for="">@lang('admin.username'): </label>
                        <a href="#" data-type="text" class="input-editable editable-click" id="card_title_editable" style="text-transform: capitalize;">{{ Auth::user()->name }}</a>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('email'): </label>
                        <a href="#" data-type="text" class="input-editable editable-click" id="card_title_editable" style="text-transform: capitalize;">{{ Auth::user()->email }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
