<div class="modal fade" id="create-new-board">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">ساختن یک بورد جدید</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form" class="create-board-form">
                @csrf
                    <div class="form-group" id="boardTitleCon">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="boardTitle" name="boardName">
                    </div>
                    <div class="form-group">
                        <h4>گروه</h4>
                        <p>
                            گروه اجازه میده که شما کارها و بورد های گروه رو ببینید به نظر میرسه شما عضو هیچ گروهی نیستید <a data-toggle="modal" href='#create-team'>یک گروه بسازید</a>.
                        </p>
                    </div>
                    <div class="form-group" id="boardPrivacyTypeCon">
                        <p><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> این بورد خصوصی خواهد بود</p>
                        <select name="boardPrivacyType" id="boardPrivacyType" class="form-control" required="required">
                            <option value="private">خصوصی</option>
                            <option value="team">گروهی</option>
                            <option value="public">عمومی</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                <button type="button" class="btn btn-primary" id="save-board">ذخیره تغییرات</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="see-closed-board">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>بستن بورد</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default panel-custom">
                    <div class="panel-body">
                        <p>بورد بسته شده ای تابحال وجود نداشته.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create-team">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>ساختن گروه</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="POST" role="form">
                        @csrf
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <textarea name="description" id="description" class="form-control" rows="3" required="required"></textarea>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-group">ساختن گروه</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-profile-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">ویرایش پروفایل</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form">
                @csrf
                    <div class="form-group">
                        <label for="title">نام کامل</label>
                        <input type="text" class="form-control" id="fullname">
                    </div>
                    <div class="form-group">
                        <label for="title">نام کاربری</label>
                        <input type="text" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="title">بیوگرافی شما</label>
                        <textarea name="" id="input" class="form-control" rows="3" required="required"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary" id="save-change">ذخیره تغییرات</button>
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
                            <a href="#general" aria-controls="tab" role="tab" data-toggle="tab">عمومی</a>
                        </li>
                        <li role="presentation">
                            <a href="#date" aria-controls="tab" role="tab" data-toggle="tab">تاریخ</a>
                        </li>
                        <li role="presentation">
                            <a href="#subtasks" aria-controls="tab" role="tab" data-toggle="tab">کارهای مرتبط و وابسته</a>
                        </li>
                        <li role="presentation">
                            <a href="#comments" aria-controls="tab" role="tab" data-toggle="tab">اظهار نظر ها</a>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="padding-top: 10px; padding-left: 35px; padding-right: 35px;">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="general">
                            <form action="" method="POST" role="form">
                            @csrf
                                <div class="form-group">
                                    <label for="">عنوان کار</label>
                                    <a href="#" data-type="text" class="input-editable editable-click" title="Enter Card Title" id="card_title_editable">Empty</a>
                                </div>
                                <div class="form-group">
                                    <label for="">توضیحات</label>
                                    <a href="#" data-type="textarea" class="input-editable editable-click" title="Enter Card Description" id="card_description_editable">Empty</a>
                                </div>
                                <div class="form-group">
                                    <label for="">برچسب</label>
                                    <input type="text" id="card-tags-input">
                                </div>
                                <div class="form-group">
                                    <label for="">رنگ</label>
                                    <select id="card_color">
                                        <option value="">انتخاب رنگ...</option>
                                        <option value="EB5A46">قرمز</option>
                                        <option value="C377E0">بنفش</option>
                                        <option value="0079BF">آبی</option>
                                        <option value="61BD4F">سبز</option>
                                        <option value="F2D600">زرد</option>
                                        <option value="FFAB4A">نارنجی</option>
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
                            <div class="addSubTaskCon">
                                <h2>اضافه کردن یک کار به عنوان زیرشاخه</h2>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="task-description-input" required="required">
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
                                                    <button class="btn btn-default" id="submit-comment">اعمال</button>
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
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-primary" id="save-change">ذخیره تغییرات</button>
                    <button type="button" class="btn btn-danger" id="delete-card"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> پاک کردن</button>
                </div>
            </div>
        </div>
    </div>
</div>