<div class="modal fade" id="create-new-board">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">@lang('Build a new board')</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form" class="create-board-form">
                    @csrf
                    <div class="form-group" id="boardTitleCon">
                        <label for="title" class="control-label">@lang('admin.title')</label>
                        <input type="text" class="form-control" id="boardTitle" name="boardName">
                    </div>
                    <div class="form-group">
                        <h4>گروه</h4>
                        <p>
                            The group allows you to view group tasks and boards. You do not appear to be a member of any groups - گروه اجازه میده که شما کارها و بورد های گروه رو ببینید به نظر میرسه شما عضو هیچ گروهی نیستید <a data-toggle="modal" href='#create-team'>Create a group - یک گروه بسازید</a>.
                        </p>
                    </div>
                    <div class="group-con frame" style="margin-top: 12px; max-height: 235px; overflow: scroll;"></div>

                    <div class="form-group" id="boardAdminUserIdCon">
                        <p><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>@lang('Board Manager')</p>
                        <select name="boardAdminUserId" id="boardAdminUserId" class="form-control" required="required">
                            <option value="">@lang('Select a manager')...</option>
                            @if(isset($users))
                            @foreach($users as $user)
                            <option value="{{ $user['id'] }}">{{ $user["name"] }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group" id="boardPrivacyTypeCon">
                        <p><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>The board will be private - این بورد خصوصی خواهد بود</p>
                        <select name="boardPrivacyType" id="boardPrivacyType" class="form-control" required="required">
                            <option value="private">@lang('Private')</option>
                            <option value="team">@lang('Group')</option>
                            <option value="public">@lang('General')</option>
                        </select>
                    </div>
                </form>
                <!-- base_url:8000/postboard -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
                <button type="button" class="btn btn-primary" id="save-board">@lang('Save Changes')</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="see-closed-board">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Close the board - بستن بورد</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default panel-custom">
                    <div class="panel-body">
                        <p>There is no closed board yet - بورد بسته شده ای تابحال وجود نداشته.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create-team">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>@lang('Build a group')</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="POST" role="form" class="create-group-form">
                            @csrf
                            <div class="form-group">
                                <label for="name">@lang('admin.name')</label>
                                <input type="text" class="form-control" name="name" id="group-name" required="required">
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <textarea name="description" id="group-description" class="form-control" rows="3" required="required"></textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                                <p>
                                    یک گروه شامل افراد و بورد های مرتبط با شماست. کمک میکنه برای سازمان دهی و مدیریت بهتر کارها
                                </p>
                                <br />
                                <p>
                                    <input type="radio"> گزینه ی <b>بیزینس کلاس </b>برای امنیت بالاتر و مدیریت بهتر عضویت را ارتقا دهید </input>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-group">@lang('Build a group')</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-profile-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">@lang('Edit Profile')</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form">
                    @csrf
                    <div class="form-group">
                        <label for="title">@lang('Full Name')</label>
                        <input type="text" class="form-control" id="fullname">
                    </div>
                    <div class="form-group">
                        <label for="title">@lang('admin.username')</label>
                        <input type="text" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label for="title">@lang('admin.title')</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="title">@lang('Your biography')</label>
                        <textarea name="" id="input" class="form-control" rows="3" required="required"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                <button type="button" class="btn btn-primary" id="save-change">@lang('Save Changes')</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="card-detail">
    <div class="modal-dialog" style="width: 720px;">
        <div class="modal-content">
            <div role="tabpanel">
                <div class="modal-header" style="border-bottom: none; padding-bottom: 0px !important;">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#general" aria-controls="tab" role="tab" data-toggle="tab">@lang('General')</a>
                        </li>
                        <li role="presentation">
                            <a href="#date" aria-controls="tab" role="tab" data-toggle="tab">@lang('Date')</a>
                        </li>
                        <li role="presentation">
                            <a href="#subtasks" aria-controls="tab" role="tab" data-toggle="tab">@lang('Related and affiliated tasks')</a>
                        </li>
                        <li role="presentation">
                            <a href="#comments" aria-controls="tab" role="tab" data-toggle="tab">@lang('Comments')</a>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="padding-top: 10px; padding-left: 35px; padding-right: 35px;">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="general">
                            <form action="" method="POST" role="form">
                                @csrf
                                <div class="form-group">
                                    <label for="">@lang('Job Title')</label>
                                    <a href="#" data-type="text" class="input-editable editable-click" title="{{ trans('board.EnterCardTitle') }}" id="card_title_editable">{{ trans('board.Empty') }}</a>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('Description')</label>
                                    <a href="#" data-type="textarea" class="input-editable editable-click" title="{{ trans('board.EnterCardDescription') }}" id="card_description_editable">{{ trans('board.Empty') }}</a>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('Tag')</label>
                                    <input type="text" id="card-tags-input">
                                    <!-- updateCardownerid -->
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('Color')</label>
                                    <select id="card_color">
                                        <option value="">@lang('Select a color')...</option>
                                        <option value="EB5A46">قرمز</option>
                                        <option value="C377E0">بنفش</option>
                                        <option value="0079BF">آبی</option>
                                        <option value="61BD4F">سبز</option>
                                        <option value="F2D600">زرد</option>
                                        <option value="FFAB4A">نارنجی</option>
                                    </select>
                                </div>
                                <div class="form-group" id="card-owner-div">
                                    <label for="">مدیر کارت</label>
                                    <select id="card-owner-select">
                                        <option value="">انتخاب مدیر...</option>
                                        @if(isset($users))
                                        @foreach($users as $user)
                                        <option value="{{ $user['id'] }}">{{ $user["name"] }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="date">
                            <h1>اضافه کردن تاریخ موعد</h1>
                            <hr>
                            <form action="" method="POST" role="form" style="height: 65px;">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h1 class="label" style="color: #333333; padding-left: 0px; font-size: 16px;">ساخته شده در تاریخ: </h1>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                            <input type='text' class="form-control" id='created-at' aria-describedby="basic-addon1" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h1 class="label" style="color: #333333; padding-left: 0px; font-size: 16px;">موعد: </h1>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                            <input type='text' class="form-control" data-format="dd-MM-yyyy hh:mm:ss" id='due-date' aria-describedby="basic-addon1" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="subtasks">
                            برای تغییر مجری هر کار باید آن را پاک کنید و مجددا با همان عنوان به دیگری واگذار کنید
                            <div class="addSubTaskCon">
                                <h2>1اضافه کردن یک کار به عنوان زیرشاخه</h2>
                                <div class="input-group">
                                    <input type="text" class="form-control task-title" id="task-description-input" required="required">
                                    <div class="selectize-control single rtl">
                                        <select id="task-owner-select">
                                            <option value="">انتخاب شخص...</option>
                                            @if(isset($users))
                                            @foreach($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user["name"] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" id="submit-task">اضافه</button>
                                    </span>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 19px; margin-bottom: 19px;">
                                <div class="col-lg-8 col-lg-offset-2">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped per-tasks-completed" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-list-con frame" style="margin-top: 12px; max-height: 235px; overflow: scroll;"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="comments">
                            <div class="row" style="margin-top: 13px;">
                                <div class="col-lg-12">
                                    <h1 style="font-family: monospace; font-size: 23px; font-weight: 700; margin: 0;">اظهار نظرها: </h1>
                                    <hr style="margin-top: 5px;">
                                    <form method="POST" role="form" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <textarea name="adasd" id="comment-input" class="form-control" rows="3" required="required"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <button class="btn btn-default" id="submit-comment">@lang('Actions')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="detailBox">
                                        <div class="actionBox">
                                            <ul class="commentList frame">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">@lang('admin.close')</button>
                    <button type="button" class="btn btn-primary" id="save-change">@lang('Save Changes')</button>
                    <button type="button" class="btn btn-danger" id="delete-card"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> پاک کردن</button>
                </div>
            </div>
        </div>
    </div>
</div>
