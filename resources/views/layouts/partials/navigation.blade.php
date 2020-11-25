@if(!Auth::check())
<h1 style="color: #393333; text-align: center;font-family: byekan,arvo;font-weight: 800;position: fixed;top: 8px;margin: 0px;/* left: 50%; */width: 100%;"><span id="brand-name"></span></h1>
@endif
@if (Auth::check())
<button type="button" style="display:none;" id="nav-bar-toggle" class="navbar-toggle toggle-right pull-right" data-toggle="sidebar" data-target=".sidebar-right" style="border-color: #ddd; margin-left: 10px; position: absolute; z-index: 1000;">
    <span class="icon-bar" style="background-color: #888;"></span>
    <span class="icon-bar" style="background-color: #888;"></span>
    <span class="icon-bar" style="background-color: #888;"></span>
</button>

<div class="col-xs-7 col-sm-3 col-md-3 frame sidebar sidebar-right sidebar-animate" style="padding: 0px; background-color: #fff; border-right: 1px solid #eee;top: 0;box-shadow: 0px 0px 12px rgba(0,0,0,.175); z-index: 10000;">
    <h1 style="text-align: center; font-family: arvo; font-weight: 800; margin-bottom: 20px;"><a href="{{ route('user.dashboard') }}" style="color: #393333;">مدیریت کارها</a></h1>
    <ul class="nav navbar-stacked sidebar-inner">
        <li>
            <div class="media" style="padding-right: 15px;">
                <div class="pull-right">
                    <img class="media-object img-responsive img-thumbnail" src="{{ asset('img/user_1.jpg') }}">
                </div>
                <div class="media-body">
                    <h4 class="media-heading" style="text-transform: capitalize; font-weight: bold;">{{ Auth::user()->name }}</h4>
                    <p><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {{ Auth::user()->email }}</p>
                    <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span> عضو از تاریخ {{ Carbon\Carbon::parse(Auth::user()->created_at)->toFormattedDateString() }}</p>
                    <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span> عضو از تاریخ {{ verta(Auth::user()->created_at) }}</p>
                </div>
            </div>
        </li>
        <li>
            <form class="navbar-form" role="search" id="selet-board-form">
                @csrf
                <div class="form-group">
                    <select id="select-board">
                        <option value="">@lang('Select a baord')...</option>
                        @foreach($boards as $board)
                        @if(isset($boardDetail) && $board['id'] == $boardDetail['id'])
                        <option value="{{ $board['id'] }}" selected>{{ $board["boardTitle"] }}</option>
                        @else
                        <option value="{{ $board['id'] }}">{{ $board["boardTitle"] }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default" style="margin-bottom: 5px;">انتخاب</button>
                </div>

            </form>

            @if(isset($boardDetail))
            <form class="navbar-form" role="searchUser" id="select-user-form">
                @csrf
                <div class="form-group selectize-control single rtl" id="boardAdminUserIdCon">
                    <p><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>@lang('Board Manager')</p>
                    <select name="boardAdminUserId2" id="boardAdminUserId2" class="selectize-input items not-full has-options" required="required">
                        @if(isset($users))
                        @foreach($users as $user)
                        @if($boardDetail['owner_id'] == $user['id'])
                        <option value="{{ $user['id'] }}" selected>{{ $user["name"] }}</option>
                        @else
                        <option value="{{ $user['id'] }}">{{ $user["name"] }}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
                <input type="text" id="board_id" value="{{isset($boardDetail)?$boardDetail['id']:''}}" style="display:none;" />
                <input type="text" id="adminUserId" value="" style="display:none;" />
                <div class="form-group">
                    <button type="submit" class="btn btn-default" style="margin-bottom: 5px;">@lang('Actions')</button>
                </div>
            </form>
            @endif
        </li>
        <li>
            <div class="panel-group" style="padding-left: 15px; padding-right: 15px;">
                <div class="panel panel-default" style="width: 295px;">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#starred-board">
                            <h3 class="panel-title" style="color: #393333;">
                                @lang('Starred boards')<span class="glyphicon glyphicon-star pull-right" aria-hidden="true"></span>
                            </h3>
                        </a>
                    </div>
                    <div id="starred-board" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul style="padding-left: 0px;" class="stared-board-list-con">
                                @foreach($boards as $board)
                                <li style="margin-bottom: 5px;" data-boardid="{{ $board->id }}"><a href="{{ url('board') . '/' . $board['id'] }}" style="color: #393333; padding-left: 0px; line-height: 20px; height: 20px;">{{ $board["boardTitle"] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li style="padding-left: 15px; padding-right: 30px;">
            <a data-toggle="modal" href="#create-new-board" style="color: #393333;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>@lang('Build a new board')</a>
        </li>
        <hr>
        <li style="padding-left: 15px; padding-right: 30px;">
            <a href="{{ route('user.dashboard') }}" style="color: #393333;"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('board.Home') }}</a>
        </li>
        <li style="padding-left: 15px; padding-right: 30px;">
            <a href="{{ route('user.activity') }}" style="color: #393333;"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span> {{ trans('board.Activity') }}</a>
        </li>
        <li style="padding-left: 15px; padding-right: 30px;">
            <a href="{{ route('user.profile') }}" style="color: #393333;"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> {{ trans('board.Profile') }}</a>
        </li>
        <li style="padding-left: 15px; padding-right: 30px;">
            <a href="{{ route('user.setting') }}" style="color: #393333;"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> {{ trans('board.Setting') }}</a>
        </li>
        <li style="padding-left: 15px; padding-right: 30px;">
            <a href="{{ url('/logout') }}" style="color: #393333;"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> {{ trans('board.Logout') }}</a>
        </li>
    </ul>
</div>
@endif
<div class="overlay"></div>
