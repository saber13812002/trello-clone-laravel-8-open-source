$(document).ready(function () {
    var Board = {
        init: function (params) {
            this.params = params;
            this.bindUI();
            this.initCradDrag();
            this.initEditableListName();
        },
        initCradDrag: function () {
            $(".card-con").each(function (index, el) {
                $(el)
                    .sortable({
                        scroll: true,
                        connectWith: ".card-con",
                        placeholder: "dashed-placeholder",
                        revert: 200,
                        receive: function (event, ui) {
                            var targetList = event.target;
                            var targetCard = ui.item[0];
                            var listId = $(targetList).data("listid");
                            var cardId = $(targetCard).data("cardid");

                            $.ajax({
                                url: "changeCardList",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    listId: listId,
                                    cardId: cardId,
                                },
                                success: function (data) {
                                    console.log(data);
                                },
                                error: function (error) {
                                    var response = JSON.parse(
                                        error.responseText
                                    );
                                    console.log(response);
                                },
                            });
                        },
                    })
                    .disableSelection();
            });
        },
        initEditableListName: function () {
            var that = this;
            $(".board-panel-title").each(function (index, el) {
                $.fn.editable.defaults.mode = "popup";
                $(el).editable({
                    validate: function (value) {
                        if ($.trim(value) == "") return "Value is required.";
                    },
                    type: "text",
                    url: "update-list-name",
                    title: "ویرایش نام لیست",
                    placement: "right",
                    send: "always",
                    ajaxOptions: {
                        dataType: "json",
                        success: function () {
                            var listId = $(el).attr("data-pk");
                            that.createActivity(
                                listId,
                                "board_list",
                                "ویرایش نام لیست"
                            );
                        },
                    },
                });
            });
        },
        bindUI: function () {
            var that = this;

            $(".create-board-form").on("submit", function (e) {
                e.preventDefault();
                that.saveBoard();
            });

            this.params["saveBoardBtn"].on("click", function (event) {
                event.preventDefault();
                that.saveBoard();
            });

            $("#saveListName").on("click", function (event) {
                event.preventDefault();
                that.saveList(
                    $(this).closest(".panel-body").find("form").serialize(),
                    this
                );
            });

            $(document).on("click", ".show-input-field", function () {
                var currentList = $(this).hide();
                that.targetList = $(currentList).parent();
                $(this).closest(".panel-body").find("form").show();
            });

            $(document).on("click", ".close-input-field", function () {
                $(this).closest(".panel-body").find(".show-input-field").show();
                $(this).closest(".panel-body").find("form").hide();
            });

            $(document).on("click", "#saveCard", function (event) {
                event.preventDefault();
                that.saveCard(
                    $(this).closest(".panel-body").find("form").serialize(),
                    this
                );
            });

            $(document).on("click", ".board-list-items", function () {
                var cardId = $(this).data("cardid");
                $(".modal#card-detail")
                    .find("button#delete-card")
                    .data("cardid", cardId);
                that.putCardDetailInModal(cardId);
            });

            $(document).on("click", "button#delete-card", function () {
                var cardId = $(this).data("cardid");
                var cardIdCon = $(".list-group-item").filter(
                    "[data-cardid=" + cardId + "]"
                );
                that.deleteCard(cardId, cardIdCon);
            });

            $(document).on("click", "a.delete-task", function (event) {
                event.preventDefault();
                var taskId = $(this).attr("data-taskId");
                that.deleteTask(taskId, this);
            });

            $(document).on("click", "#save-change", function (event) {
                //updateCardownerid
                event.preventDefault();
                var cardId = $(document)
                    .find("#card-detail")
                    .attr("data-cardid");
                that.saveChanges(cardId);
            });

            $(".create-group-form").on("submit", function (e) {
                e.preventDefault();
                that.addGroup();
            });

            this.params["addGroupBtn"].on("click", function (event) {
                event.preventDefault();
                that.addGroup();
            });

            // $(document).on('click', '#add-group', function(event) {
            //     event.preventDefault();
            //     that.addGroup(this);
            // });

            $(document).on("click", "#submit-comment", function () {
                var comment = $("#card-detail").find("#comment-input").val();
                var cardId = $(document)
                    .find("#card-detail")
                    .attr("data-cardid");
                if (comment.length > 0) {
                    event.preventDefault();
                    that.postComment(comment, cardId);
                }
            });

            $(document).on("click", "#submit-task", function () {
                var taskTitle = $("#card-detail")
                    .find("#task-description-input")
                    .val();
                var cardId = $(document)
                    .find("#card-detail")
                    .attr("data-cardid");
                var taskOwnerId = $(document).find("#task-owner-select").val();
                //console.log(taskOwnerId);
                if (taskTitle.length > 0) {
                    event.preventDefault();
                    that.saveTask(taskTitle, taskOwnerId, cardId);
                }
            });

            $(document).on("click", ".sub-task-content", function () {
                var isCompleted;
                var isChecked = $(this)
                    .closest("div")
                    .find("input.sub-task-title-input")
                    .attr("data-checked");
                var taskId = $(this).attr("data-taskid");

                if (isChecked == 0) {
                    isCompleted = 1;
                    $(this)
                        .closest("div")
                        .find("input.sub-task-title-input")
                        .attr("data-checked", 1);
                    that.updateTaskCompleted(taskId, isCompleted);
                } else {
                    isCompleted = 0;
                    $(this)
                        .closest("div")
                        .find("input.sub-task-title-input")
                        .attr("data-checked", 0);
                    that.updateTaskCompleted(taskId, isCompleted);
                }
            });

            that.makeEditable("#select-board");

            $(document).on("click", "#make-fv-board", function (event) {
                event.preventDefault();
                event.stopPropagation();

                var starColor = $(this).css("color");
                var boardId = $(this)
                    .closest(".board-link")
                    .attr("data-boardid");
                var isFavourite;
                if (starColor == "rgb(255, 255, 255)") {
                    isFavourite = 1;

                    $(this).css("color", "#FFEB3B");
                    var boardCon = $(this).closest(".col-lg-3").clone();
                    var boardTitle = $(boardCon).find("h2").text().trim();
                    if (
                        $(".my-fv-board").find("h1.board-starred-heading")
                            .length == 0
                    ) {
                        $(".my-fv-board").prepend(
                            '<h1 class="board-starred-heading" style="margin-top: 10px;margin-left: 15px;font-weight: 500;font-size: 25px;"><span class="glyphicon glyphicon-star-empty starred-boards" aria-hidden="true"></span> Starred Boards</h1>'
                        );
                    }

                    if (
                        $(".my-fv-board").find(".boards-col .col-lg-3")
                            .length == 0
                    ) {
                        $(".my-fv-board").css("display", "block");
                    }
                    $(boardCon).find(".col-lg-2").remove();
                    $(".my-fv-board").find(".boards-col").prepend(boardCon);
                    $("ul.stared-board-list-con").prepend(
                        '<li style="margin-bottom: 5px;" data-boardid="' +
                            boardId +
                            '">' +
                            '<a href="http://localhost:8000/board/' +
                            boardId +
                            '" style="color: #393333; padding-left: 0px; line-height: 20px; height: 20px; mar">' +
                            boardTitle +
                            "</a>" +
                            "</li>"
                    );
                    that.createActivity(boardId, "board", "fav a board");
                } else {
                    $(this).css("color", "#FFF");
                    isFavourite = 0;
                    $(".my-fv-board")
                        .find(".boards-col .col-lg-3")
                        .filter("[data-boardid=" + boardId + "]")
                        .remove();
                    if (
                        $(".my-fv-board").find(".boards-col .col-lg-3")
                            .length == 0
                    ) {
                        $(".my-fv-board").css("display", "none");
                    }
                    $("ul.stared-board-list-con")
                        .find("li")
                        .filter("[data-boardid=" + boardId + "]")
                        .remove();
                    that.createActivity(boardId, "board", "un-fav a board");
                }
                that.updateBoardFavourite(boardId, isFavourite);
            });

            $(".board-link").hover(
                function () {
                    $(this).find("#make-fv-board").slideDown("fast");
                },
                function () {
                    $(this).find("#make-fv-board").slideUp("fast");
                }
            );

            $(document).on("click", ".board-link", function () {
                var boardId = $(this).attr("data-boardid");
                window.location.replace("board/" + boardId);
            });

            $(document).on("submit", "#selet-board-form", function (event) {
                event.preventDefault();
                var boardId = $("#select-board").val();
                var location = window.location;

                if (location.pathname.substr(1, 5) === "board") {
                    location.replace(boardId);
                } else {
                    location.replace("board/" + boardId);
                }
            });

            // $("#boardAdminUserId").on("change", "", function (e) {
            //     var optionSelected = $("option:selected", this);
            //     var valueSelected = this.value;
            //     console.log(valueSelected);
            // });

            $(document).on("submit", "#select-user-form", function (event) {
                event.preventDefault();
                var boardAdminUserId = $("#boardAdminUserId2").val();
                var board_id = $("#board_id").val();
                var location = window.location;

                $.ajax({
                    url: "set-board-admin",
                    type: "POST",
                    dataType: "json",
                    data: {
                        boardAdminUserId: boardAdminUserId,
                        board_id: board_id,
                    },
                    success: function (data) {
                        location.reload();
                    },
                    error: function (error) {
                        location.reload();
                    },
                });
            });

            $(document).on("click", ".delete-list", function () {
                var listId = $(this).data("listid");
                that.deleteList(listId, this);
            });
        },
        deleteList: function (listId, listTrash) {
            var that = this;
            swal(
                {
                    title: "مطمئن هستید؟",
                    text:
                        "شما دیگر قادر به برگرداندن کارت ها و لیست نخواهید بود ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "بله، پاکش کن",
                    cancelButtonText: "نخیر، منصرف شدم!",
                    closeOnConfirm: false,
                },
                function () {
                    $.ajax({
                        url: "delete-list",
                        type: "POST",
                        dataType: "json",
                        data: {
                            listId: listId,
                        },
                        success: function (data) {
                            $(listTrash).closest(".bcategory-list").remove();
                            swal(
                                "پاک شد!",
                                "با موفقت برای همیشه پاک شد!",
                                "success"
                            );
                            that.createActivity(
                                listId,
                                "board_list",
                                "deleted a list"
                            );
                        },
                        error: function (error) {
                            var response = JSON.parse(error.responseText);
                            swal(
                                "اوه",
                                "اتصال به سرور نیست. مجدد آزمایش کنید!",
                                "error"
                            );
                        },
                    });
                }
            );
        },
        updateBoardFavourite: function (boardId, isFavourite) {
            $.ajax({
                url: "update-board-favourite",
                type: "POST",
                dataType: "json",
                data: {
                    boardId: boardId,
                    isFavourite: isFavourite,
                },
                success: function (data) {
                    // console.log(data);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        updateTaskCompleted: function (taskId, isCompleted) {
            var cardId = $(document).find("#card-detail").attr("data-cardid");
            $.ajax({
                url: "update-task-completed",
                type: "POST",
                dataType: "json",
                data: {
                    taskId: taskId,
                    isCompleted: isCompleted,
                    cardId: cardId,
                },
                success: function (data) {
                    var perTaskCompleted = Math.floor(
                        (data.totalTasksCompleted / data.totalTasks) * 100
                    );
                    $(document).find(".per-tasks-completed").addClass("active");
                    $(document)
                        .find(".per-tasks-completed")
                        .attr("aria-valuenow", perTaskCompleted);
                    $(document)
                        .find(".per-tasks-completed")
                        .css("width", perTaskCompleted + "%");
                    $(document)
                        .find(".per-tasks-completed")
                        .find(".show")
                        .text(perTaskCompleted + "% کارها انجام شده");
                    setTimeout(function () {
                        $(document)
                            .find(".per-tasks-completed")
                            .removeClass("active");
                    }, 2000);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        saveTask: function (taskTitle, taskOwnerId, cardId) {
            var that = this;
            $.ajax({
                url: "save-task",
                type: "POST",
                dataType: "json",
                data: {
                    taskTitle: taskTitle,
                    taskOwnerId: taskOwnerId,
                    cardId: cardId,
                },
                success: function (data) {
                    var task =
                        '<div class="form-group sub-task-con">' +
                        '<div class="row">' +
                        '<div class="col-lg-11 style="float:right;"">' +
                        '<input class="magic-checkbox sub-task-title-input" type="checkbox" name="layout" id="' +
                        data.card["id"] +
                        '" value="option" ' +
                        (data.card["is_completed"] == 1
                            ? ' checked="checked" data-checked="1"'
                            : 'data-checked="0"') +
                        ">" +
                        '<label for="' +
                        data.card["id"] +
                        '" class="sub-task-content" data-taskid="' +
                        data.card["id"] +
                        '">' +
                        data.card["task_title"] +
                        " - " +
                        data.card["owner"];
                    "</label>" +
                        "</div>" +
                        '<div class="col-lg-1">' +
                        '<a href="" class="delete-task" data-taskId="' +
                        data.card["id"] +
                        '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>' +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $("#card-detail").find(".task-list-con").prepend(task);
                    $("#card-detail").find("#task-description-input").val("");

                    var perTaskCompleted = Math.floor(
                        (data.totalTasksCompleted / data.totalTasks) * 100
                    );
                    if (isNaN(perTaskCompleted)) {
                        perTaskCompleted = 0;
                    }
                    $(document).find(".per-tasks-completed").addClass("active");
                    $(document)
                        .find(".per-tasks-completed")
                        .attr("aria-valuenow", perTaskCompleted);
                    $(document)
                        .find(".per-tasks-completed")
                        .css("width", perTaskCompleted + "%");
                    $(document)
                        .find(".per-tasks-completed")
                        .find(".show")
                        .text(perTaskCompleted + "%کارها انجام شده");
                    setTimeout(function () {
                        $(document)
                            .find(".per-tasks-completed")
                            .removeClass("active");
                    }, 2000);

                    if (
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("ul.card-description-intro #totalTasks")
                            .length == 0
                    ) {
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("ul.card-description-intro")
                            .append(
                                '<li id="totalTasks">' +
                                    '<a href="#" data-placement="bottom" data-toggle="tooltip" title="" data-totaltask="1" data-original-title="This card have 1 tasks."><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a>' +
                                    "</li>"
                            );
                    } else {
                        var totalTasks = $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("#totalTasks a")
                            .attr("data-totaltask");
                        totalTasks++;
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("#totalTasks a")
                            .attr(
                                "data-original-title",
                                "This card have " + totalTasks + " tasks."
                            );
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("#totalTasks a")
                            .attr("data-totaltask", totalTasks);
                    }
                    that.reInitializeToolTip();
                    that.createActivity(cardId, "card_task", "task is added");
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        postComment: function (comment, cardId) {
            var that = this;
            $.ajax({
                url: "save-comment",
                type: "POST",
                dataType: "json",
                data: {
                    comment: comment,
                    cardId: cardId,
                },
                success: function (data) {
                    comment =
                        "<li>" +
                        '<div class="row">' +
                        '<div class="col-lg-2">' +
                        '<div class="commenterImage">' +
                        '<img src="' +
                        assetUserImage +
                        '" class="img-responsive" />' +
                        "</div>" +
                        "</div>" +
                        '<div class="col-lg-10">' +
                        '<div class="comment-user-name">' +
                        "<h1>" +
                        data[0].name +
                        "</h1>" +
                        "</div>" +
                        '<div class="commentText">' +
                        '<p class="">' +
                        data[0].comment_description +
                        '</p> <span class="date sub-text">' +
                        that.time_ago(data[0].created_at) +
                        "</span>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</li>";
                    $("#card-detail").find("ul.commentList").prepend(comment);
                    $("#card-detail").find("#comment-input").val("");

                    if (
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("ul.card-description-intro  #totalComments")
                            .length == 0
                    ) {
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("ul.card-description-intro")
                            .append(
                                '<li id="totalComments">' +
                                    '<a href="#" data-placement="bottom" data-toggle="tooltip" title="" data-totalcomments="1" data-original-title="This card have 1 comments."><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></a>' +
                                    "</li>"
                            );
                    } else {
                        var totalComments = $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("#totalComments a")
                            .attr("data-totalcomments");
                        totalComments++;
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("#totalComments a")
                            .attr(
                                "data-original-title",
                                "This card have " + totalComments + " comments."
                            );
                        $(".list-group-item")
                            .filter("[data-cardid=" + cardId + "]")
                            .find("#totalComments a")
                            .attr("data-totalComments", totalComments);
                    }

                    that.createActivity(
                        data[0].id,
                        "comment",
                        "posted a comment"
                    );
                    that.reInitializeToolTip();
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        saveChanges: function (cardId) {
            //updateCardownerid
            var that = this;
            var cardName = $(document).find("#card_title_editable").text();
            var cardDescription = $(document)
                .find("#card_description_editable")
                .text();
            var cardTags = $(document).find("#card-tags-input").val(); //
            var cardColor = $(document).find("#card_color").val();
            var cardDueDate = $(document).find("#due-date").val();
            var cardId = $(document).find("#card-detail").attr("data-cardid");
            var ownerId = $(document).find("#card-owner-select").val();

            $.ajax({
                url: "update-card-data", // updateCardownerid
                type: "POST",
                dataType: "json",
                data: {
                    cardName: cardName,
                    cardDescription: cardDescription,
                    cardTags: cardTags,
                    cardColor: cardColor,
                    cardDueDate: cardDueDate,
                    cardId: cardId,
                    ownerId: ownerId,
                },
                success: function (data) {
                    $(".list-group-item")
                        .filter("[data-cardid=" + data.cardId + "]")
                        .find("p")
                        .text(data.cardTitle);
                    if (cardColor.length > 0) {
                        $(document)
                            .find(".list-group-item")
                            .filter("[data-cardid=" + data.cardId + "]")
                            .css("border-top", "5px solid #" + cardColor);
                    } else {
                        $(document)
                            .find(".list-group-item")
                            .filter("[data-cardid=" + data.cardId + "]")
                            .removeAttr("style");
                    }
                    if (cardDescription != "Empty") {
                        $(document)
                            .find(".list-group-item")
                            .filter("[data-cardid=" + data.cardId + "]")
                            .find(".card-description-intro #card_description")
                            .remove();
                        $(document)
                            .find(".list-group-item")
                            .filter("[data-cardid=" + data.cardId + "]")
                            .find(".card-description-intro")
                            .prepend(
                                '<li id="card_description">' +
                                    '<a href="#" data-placement="bottom" data-toggle="tooltip" title="" data-original-title="This card has a description."><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span></a>' +
                                    "</li>"
                            );
                    } else {
                        $(document)
                            .find(".list-group-item")
                            .filter("[data-cardid=" + data.cardId + "]")
                            .find(".card-description-intro #card_description")
                            .remove();
                    }
                    // fixme TODO if change the name of owner tooltip remain by original value
                    that.reInitializeToolTip();
                    $(".modal#card-detail").modal("hide");
                    that.createActivity(
                        data.cardId,
                        "board_card",
                        "card is edited"
                    );
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        reInitializeToolTip: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        deleteTask: function (taskId, deleteTaskBtn) {
            var that = this;
            var cardId = $(document).find("#card-detail").attr("data-cardid");
            swal(
                {
                    title: "مطمئن هستید؟",
                    text: "You will not be able to recover this Task!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "بله، پاکش کن",
                    closeOnConfirm: false,
                },
                function () {
                    $.ajax({
                        url: "delete-task",
                        type: "POST",
                        dataType: "json",
                        data: {
                            taskId: taskId,
                            cardId: cardId,
                        },
                        success: function (data) {
                            $(deleteTaskBtn).closest(".form-group").remove();
                            var cardId = $(".modal#card-detail").attr(
                                "data-cardid"
                            );
                            var totalTasks = $(".list-group-item")
                                .filter("[data-cardid=" + cardId + "]")
                                .find("#totalTasks a")
                                .attr("data-totaltask");
                            totalTasks--;
                            $(".list-group-item")
                                .filter("[data-cardid=" + cardId + "]")
                                .find("#totalTasks a")
                                .attr(
                                    "data-original-title",
                                    "This card have " + totalTasks + " tasks."
                                );
                            $(".list-group-item")
                                .filter("[data-cardid=" + cardId + "]")
                                .find("#totalTasks a")
                                .attr("data-totaltask", totalTasks);

                            var perTaskCompleted;

                            if (data.totalTasks != 0) {
                                perTaskCompleted = Math.floor(
                                    (data.totalTasksCompleted /
                                        data.totalTasks) *
                                        100
                                );
                            } else {
                                perTaskCompleted = 0;
                                $(".list-group-item")
                                    .filter("[data-cardid=" + cardId + "]")
                                    .find("#totalTasks")
                                    .remove();
                            }

                            $(document)
                                .find(".per-tasks-completed")
                                .addClass("active");
                            $(document)
                                .find(".per-tasks-completed")
                                .attr("aria-valuenow", perTaskCompleted);
                            $(document)
                                .find(".per-tasks-completed")
                                .css("width", perTaskCompleted + "%");
                            $(document)
                                .find(".per-tasks-completed")
                                .find(".show")
                                .text(perTaskCompleted + "%کارها انجام شده");
                            setTimeout(function () {
                                $(document)
                                    .find(".per-tasks-completed")
                                    .removeClass("active");
                            }, 2000);
                            that.createActivity(
                                cardId,
                                "card_task",
                                "task is deleted"
                            );
                            swal(
                                "پاک شد!",
                                "با موفقیت برای همیشه پاک شد!",
                                "success"
                            );
                        },
                        error: function (error) {
                            var response = JSON.parse(error.responseText);
                            swal(
                                "اوه",
                                "اتصال به سرور از بین رفت لطفا اتصال را بررسی کنید و مجدد تست کنید!",
                                "error"
                            );
                        },
                    });
                }
            );
        },
        putCardDetailInModal: function (cardId) {
            var that = this;
            $.ajax({
                url: "getCardDetail",
                type: "POST",
                dataType: "json",
                data: {
                    cardId: cardId,
                },
                success: function (data) {
                    $(document)
                        .find("#card-detail")
                        .attr("data-cardid", data.card.id);

                    $("#card-detail")
                        .find("#card_title_editable")
                        .text(data.card.card_title);
                    that.makeEditable("#card_title_editable");

                    $("#card-detail")
                        .find("#card_description_editable")
                        .text(data.card.card_description);
                    that.makeEditable("#card_description_editable");

                    var labels = "";
                    $.each(data.label, function (index, val) {
                        labels += val.tag_title + ", ";
                    });
                    labels = labels.substr(0, labels.length - 2);
                    $("#card-tags-input").attr("value", labels);
                    that.makeEditable("#card-tags-input", labels);

                    var cardColor = data.card.card_color;
                    that.makeEditable("#card_color", cardColor);

                    var cardOwnerId = data.card.owner_id;
                    that.makeEditable("#card-owner-select", cardOwnerId);
                    // cardAdminUserId updateCardownerid
                    var createdAt = data.card.created_at;
                    createdAt = that.formatDate(createdAt);

                    var createdAtInput = $("#created-at").datepicker();
                    createdAtInput.val(createdAt).change();

                    var dueDate = data.card.due_date;
                    dueDate = that.formatDate(dueDate);

                    var dueDateInput = $("#due-date").datepicker();

                    $(".due-date").datepicker({
                        //comment the beforeShow handler if you want to see the ugly overlay
                        beforeShow: function () {
                            setTimeout(function () {
                                $(".ui-datepicker").css("z-index", 1051);
                            }, 0);
                        },
                    });

                    dueDateInput.val(dueDate).change();

                    var taskList = "",
                        countCompletedTasks = 0,
                        countTotalTasks = 0;
                    $.each(data.task, function (index, val) {
                        countTotalTasks++;
                        if (val.is_completed) {
                            countCompletedTasks++;
                        }
                        taskList +=
                            '<div class="form-group sub-task-con">' +
                            '<div class="row">' +
                            '<div class="col-lg-11" style="float:right;">' +
                            '<input class="magic-checkbox sub-task-title-input" type="checkbox" name="layout" id="' +
                            val.id +
                            '" value="option" ' +
                            (val.is_completed == 1
                                ? 'checked="checked" data-checked="1"'
                                : 'data-checked="0"') +
                            ">" +
                            '<label for="' +
                            val.id +
                            '" class="sub-task-content" data-taskid="' +
                            val.id +
                            '">' +
                            val.task_title +
                            " - " +
                            val.owner;
                        "</label>" +
                            "</div>" +
                            '<div class="col-lg-1">' +
                            '<a href="" class="delete-task" data-taskId="' +
                            val.id +
                            '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>' +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    });
                    var perTaskCompleted;
                    if (countTotalTasks != 0) {
                        perTaskCompleted = Math.floor(
                            (countCompletedTasks / countTotalTasks) * 100
                        );
                    } else {
                        perTaskCompleted = 0;
                    }

                    $(document)
                        .find(".per-tasks-completed")
                        .attr("aria-valuenow", perTaskCompleted);
                    $(document)
                        .find(".per-tasks-completed")
                        .css("width", perTaskCompleted + "%");
                    $(document)
                        .find(".per-tasks-completed")
                        .find(".show")
                        .text(perTaskCompleted + "%کارها انجام شده");

                    $("#card-detail").find(".task-list-con").empty();
                    $("#card-detail").find(".task-list-con").append(taskList);

                    var commentList = "";
                    $.each(data.comment, function (index, val) {
                        commentList +=
                            "<li>" +
                            '<div class="row">' +
                            '<div class="col-lg-2">' +
                            '<div class="commenterImage">' +
                            '<img src="' +
                            assetUserImage +
                            '" class="img-responsive" />' +
                            "</div>" +
                            "</div>" +
                            '<div class="col-lg-10">' +
                            '<div class="comment-user-name">' +
                            "<h1>" +
                            val.name +
                            "</h1>" +
                            "</div>" +
                            '<div class="commentText">' +
                            '<p class="">' +
                            val.comment_description +
                            '</p> <span class="date sub-text">' +
                            that.time_ago(val.created_at) +
                            "</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</li>";
                    });
                    $("#card-detail").find("ul.commentList").empty();
                    $("#card-detail")
                        .find("ul.commentList")
                        .append(commentList);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        time_ago: function (time) {
            switch (typeof time) {
                case "number":
                    break;
                case "string":
                    time = +new Date(time);
                    break;
                case "object":
                    if (time.constructor === Date) time = time.getTime();
                    break;
                default:
                    time = +new Date();
            }
            var time_formats = [
                [60, "seconds", 1], // 60
                [120, "1 minute ago", "1 minute from now"], // 60*2
                [3600, "minutes", 60], // 60*60, 60
                [7200, "1 hour ago", "1 hour from now"], // 60*60*2
                [86400, "hours", 3600], // 60*60*24, 60*60
                [172800, "Yesterday", "Tomorrow"], // 60*60*24*2
                [604800, "days", 86400], // 60*60*24*7, 60*60*24
                [1209600, "Last week", "Next week"], // 60*60*24*7*4*2
                [2419200, "weeks", 604800], // 60*60*24*7*4, 60*60*24*7
                [4838400, "Last month", "Next month"], // 60*60*24*7*4*2
                [29030400, "months", 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
                [58060800, "Last year", "Next year"], // 60*60*24*7*4*12*2
                [2903040000, "years", 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
                [5806080000, "Last century", "Next century"], // 60*60*24*7*4*12*100*2
                [58060800000, "centuries", 2903040000], // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
            ];
            var seconds = (+new Date() - time) / 1000,
                token = "ago",
                list_choice = 1;

            if (seconds == 0) {
                return "Just now";
            }
            if (seconds < 0) {
                seconds = Math.abs(seconds);
                token = "from now";
                list_choice = 2;
            }
            var i = 0,
                format;
            while ((format = time_formats[i++]))
                if (seconds < format[0]) {
                    if (typeof format[2] == "string")
                        return format[list_choice];
                    else
                        return (
                            Math.floor(seconds / format[2]) +
                            " " +
                            format[1] +
                            " " +
                            token
                        );
                }
            return time;
        },
        formatDate: function (dueDate) {
            var d = new Date(dueDate),
                dformat =
                    [d.getMonth() + 1, d.getDate(), d.getFullYear()].join("/") +
                    " " +
                    [d.getHours(), d.getMinutes(), d.getSeconds()].join(":");

            return dformat;
        },
        makeEditable: function (elementId, opt) {
            switch (elementId) {
                case "#card_title_editable":
                    var cardTitle = $(elementId).text();
                    $("#card-detail")
                        .find(elementId)
                        .editable({
                            validate: function (value) {
                                if ($.trim(value) == "")
                                    return "Value is required.";
                            },
                            inputclass: "x-editable-input",
                            type: "text",
                            placement: "right",
                        });
                    $("#card-detail")
                        .find(elementId)
                        .editable("setValue", cardTitle);
                    break;
                case "#card_description_editable":
                    var cardDescription = $(elementId).text();
                    $("#card-detail").find(elementId).editable({
                        inputclass: "x-editable-input",
                        type: "text",
                        placement: "right",
                    });
                    $("#card-detail")
                        .find(elementId)
                        .editable("setValue", cardDescription);
                    break;
                case "#card-tags-input":
                    if (
                        $("#card-tags-input").hasClass("selectized") === false
                    ) {
                        if (
                            $("#card-detail").hasClass("selectized") === false
                        ) {
                            $("#card-detail").find(elementId).selectize({
                                persist: false,
                                createOnBlur: true,
                                create: true,
                            });
                        }
                    } else {
                        var opt = opt.split(",");
                        var selectize = $("#card-tags-input")[0].selectize;
                        selectize.clearOptions();
                        $(opt).each(function (index, lalbe) {
                            label = $.trim(lalbe);
                            selectize.addOption({ value: label, text: label });
                            selectize.addItem(label);
                        });
                    }
                    break;
                case "#card_color":
                    var $select = $("#card-detail").find(elementId).selectize();
                    $select[0].selectize.setValue(opt);
                    break;
                case "#card-owner-select":
                    var $select = $("#card-owner-div")
                        .find(elementId)
                        .selectize();
                    $select[0].selectize.setValue(opt);
                    if (opt) {
                        $select[0].selectize.options[opt].selected = true;
                    }
                    //$select[0].selectize.setValue(opt);
                    break; // updateCardownerid
                case "#select-board":
                    var my = $(elementId).selectize();
                    $(my)
                        .next(".selectize-control")
                        .find(".selectize-input")
                        .css("width", "218px");
                    $(my)
                        .next(".selectize-control")
                        .find(".selectize-dropdown")
                        .css("width", "210px");
                default:
                    break;
            }
        },
        deleteCard: function (cardId, cardIdCon) {
            var that = this;
            swal(
                {
                    title: "مطمئن هستید؟",
                    text:
                        "شما دیگر قادر به برگرداندن کارت ها و لیست نخواهید بود ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "بله، پاکش کن",
                    cancelButtonText: "نخیر، منصرف شدم!",
                    closeOnConfirm: false,
                },
                function () {
                    $.ajax({
                        url: "deleteCard",
                        type: "POST",
                        dataType: "json",
                        data: {
                            cardId: cardId,
                        },
                        success: function (data) {
                            $(cardIdCon).remove();
                            $(".modal#card-detail").modal("hide");
                            that.createActivity(
                                data.id,
                                "board_card",
                                "deleted a card"
                            );
                            swal(
                                "پاک شد!",
                                "با موفقیت برای همیشه پاک شد!",
                                "success"
                            );
                        },
                        error: function (error) {
                            var response = JSON.parse(error.responseText);
                            swal("اوه", "قطعیم. اتصال بررسی کنید!", "error");
                        },
                    });
                }
            );
        },
        saveCard: function (data, curentBtnClicked) {
            var that = this;
            $.ajax({
                url: "postCard",
                type: "POST",
                dataType: "json",
                data: data,
                success: function (data) {
                    $(that.targetList)
                        .find(".card-con")
                        .append(
                            '<li class="list-group-item board-list-items ui-sortable-handle" id="card_' +
                                data.id +
                                '" data-cardid="' +
                                data.id +
                                '" data-toggle="modal" href="#card-detail">' +
                                '<div class="row">' +
                                '<div class="col-lg-12">' +
                                '<p style="margin-bottom: 0px;" class="pull-left">' +
                                data.card_title +
                                "</p>" +
                                '<ul class="card-description-intro list-inline pull-right"></ul>' +
                                "</div>" +
                                "</div>" +
                                "</li>"
                        );
                    $(that.targetList).find("form").hide();
                    $(that.targetList).find("form textarea").val("");
                    $(that.targetList).find("a.show-input-field").show();
                    that.createActivity(
                        data.id,
                        "board_card",
                        "created a card"
                    );
                },
                error: function (error) {
                    var response = JSON.parse(error.responseText);
                    $(curentBtnClicked)
                        .closest("form")
                        .find("#dynamic-board-input-con")
                        .find(".alert")
                        .remove();
                    $.each(response, function (index, val) {
                        $(curentBtnClicked)
                            .closest("form")
                            .find("#dynamic-board-input-con")
                            .addClass("has-error");
                        $(curentBtnClicked)
                            .closest("form")
                            .find("#dynamic-board-input-con")
                            .prepend(
                                '<div class="alert alert-danger"><li>' +
                                    val +
                                    "</li></div>"
                            );
                    });
                },
            });
        },
        addGroup: function (data, curentBtnClicked) {
            var that = this;
            var name = $("#group-name").val();
            var description = $("#group-description").val();
            console.log(name);
            $.ajax({
                url: "post-group",
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    description: description,
                },
                success: function (data) {
                    $(".group-con").append(
                        '<li class="list-group-item board-list-items ui-sortable-handle" id="card_' +
                            data.id +
                            '" data-cardid="' +
                            data.id +
                            '" data-toggle="modal" href="#card-detail">' +
                            '<div class="row">' +
                            '<div class="col-lg-12">' +
                            '<p style="margin-bottom: 0px;" class="pull-left">' +
                            data.name +
                            " <br /> " +
                            data.description +
                            "</p>" +
                            '<ul class="card-description-intro list-inline pull-right"></ul>' +
                            "</div>" +
                            "</div>" +
                            "</li>"
                    );
                    // $(that.targetList).find('form').hide();
                    // $(that.targetList).find('form textarea').val('');
                    // $(that.targetList).find('a.show-input-field').show();
                    that.createActivity(
                        data.id,
                        "add_group",
                        "created a group: " + name + "desc: " + description
                    );
                },
                error: function (error) {
                    var response = JSON.parse(error.responseText);
                    $(curentBtnClicked)
                        .closest("form")
                        .find("#group-con")
                        .find(".alert")
                        .remove();
                    $.each(response, function (index, val) {
                        $(curentBtnClicked)
                            .closest("form")
                            .find("#group-con")
                            .addClass("has-error");
                        $(curentBtnClicked)
                            .closest("form")
                            .find("#group-con")
                            .prepend(
                                '<div class="alert alert-danger"><li>' +
                                    val +
                                    "</li></div>"
                            );
                    });
                },
            });
        },
        saveBoard: function () {
            that = this;
            $.ajax({
                url: "postBoard",
                type: "POST",
                dataType: "json",
                data: {
                    boardTitle: that.params["boardTitle"].val(),
                    boardPrivacyType: that.params["boardPrivacyType"].val(),
                    boardAdminUserId: that.params["boardAdminUserId"].val(),
                },
                success: function (data) {
                    $(that.params["createBoardLink"])
                        .closest(".col-lg-3")
                        .before(
                            '<div class="col-lg-3">' +
                                '<div class="board-link" style="cursor: pointer;" data-boardid="' +
                                data.id +
                                '">' +
                                '<div class="row">' +
                                '<div class="col-lg-10">' +
                                '<h2 style="margin-top: 5px;">' +
                                '<a href="http://localhost:8000/board?id=' +
                                data.id +
                                '" class="board-main-link-con" style="font-size: 20px; color: #FFF;">' +
                                data.boardTitle +
                                "</a>" +
                                "</h2>" +
                                "</div>" +
                                '<div class="col-lg-2">' +
                                '<p style="margin-top: 12px;">' +
                                '<a href="#" style="font-size: 20px; color: #FFF;" id="make-fv-board"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></a>' +
                                "</p>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                        );
                    that.params["createNewBoardModal"].modal("hide");
                    that.params["boardTitle"].val("");
                    that.params["boardTitleCon"].removeClass("has-error");
                    that.params["boardTitleCon"].find(".help-block").remove();
                    that.createActivity(data.id, "board", "created a board");
                },
                error: function (error) {
                    var response = JSON.parse(error.responseText);
                    that.params["boardTitleCon"].find(".help-block").remove();
                    $.each(response, function (index, val) {
                        that.params["boardTitleCon"].addClass("has-error");
                        that.params["boardTitleCon"].append(
                            '<span class="help-block"><strong>' +
                                val +
                                "</strong></span>"
                        );
                    });
                },
            });
        },
        createActivity: function (
            activity_in_id,
            changed_in,
            activity_description
        ) {
            $.ajax({
                url: "create-user-activity",
                type: "POST",
                dataType: "json",
                data: {
                    activity_in_id: activity_in_id,
                    changed_in: changed_in,
                    activity_description: activity_description,
                },
                success: function (data) {
                    console.log("data");
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },
        saveList: function (data, curentBtnClicked) {
            that = this;
            $.ajax({
                url: "postListName",
                type: "POST",
                dataType: "json",
                data: data,
                success: function (data) {
                    $(curentBtnClicked)
                        .closest(".bcategory-list")
                        .before(
                            '<div class="bcategory-list" data-list-id="' +
                                data.id +
                                '">' +
                                '<div class="panel panel-default">' +
                                '<div class="panel-heading" style="border-bottom: 0px; ">' +
                                '<div class="row">' +
                                '<div class="col-lg-10" style="float: right;">' +
                                '<h3 class="panel-title board-panel-title editable editable-click" data-pk="' +
                                data.id +
                                '">' +
                                data.list_name +
                                "</h3>" +
                                "</div>" +
                                '<div class="col-lg-2" style=" float: left; ">' +
                                '<span data-listid="' +
                                data.id +
                                '" class="glyphicon glyphicon-trash delete-list" aria-hidden="true" style="cursor: pointer;"></span>' +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                '<div class="panel-body card-list-con frame">' +
                                '<ul class="list-group">' +
                                '<div class="card-con ui-sortable" data-listid="' +
                                data.id +
                                '">' +
                                "</div>" +
                                "</ul>" +
                                '<a href="#" class="show-input-field">کارت جدید...</a>' +
                                '<form action="" method="POST" role="form" style="display: none;">' +
                                '<div class="form-group" id="dynamic-board-input-con" style="margin-bottom: 8px;">' +
                                '<textarea name="card-title" class="form-control" rows="3"></textarea>' +
                                '<input type="hidden" name="list_id" value="' +
                                data.id +
                                '">' +
                                '<input type="hidden" name="board_id" value="' +
                                data.board_id +
                                '">' +
                                "</div>" +
                                '<div class="form-group" style="margin-bottom: 0px;">' +
                                '<button type="submit" class="btn btn-primary" id="saveCard">Save</button> <span class="glyphicon glyphicon-remove close-input-field" aria-hidden="true"></span>' +
                                "</div>" +
                                "</form>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                        );
                    that.initCradDrag();
                    that.initEditableListName();
                    that.params["createNewBoardModal"].modal("hide");
                    $(".show-input-field").show();
                    $(".add-board-list-form").hide();
                    $(".add-board-list-form")
                        .find('input[type="text"]')
                        .val("");
                    that.params["boardTitle"].val("");
                    that.params["boardTitleCon"].removeClass("has-error");
                    that.params["boardTitleCon"].find(".alert").remove();
                    that.createActivity(
                        data.id,
                        "board_list",
                        "created a list"
                    );
                },
                error: function (error) {
                    var response = JSON.parse(error.responseText);
                    $(curentBtnClicked)
                        .closest("form")
                        .find("#dynamic-board-input-con")
                        .find(".alert")
                        .remove();
                    $.each(response, function (index, val) {
                        $(curentBtnClicked)
                            .closest("form")
                            .find("#dynamic-board-input-con")
                            .addClass("has-error");
                        $(curentBtnClicked)
                            .closest("form")
                            .find("#dynamic-board-input-con")
                            .prepend(
                                '<div class="alert alert-danger"><li>' +
                                    val +
                                    "</li></div>"
                            );
                    });
                },
            });
        },
    };
    Board.init({
        boardTitle: $("#boardTitle"),
        boardPrivacyType: $("#boardPrivacyType"),
        boardAdminUserId: $("#boardAdminUserId"),
        saveBoardBtn: $("#save-board"),
        addGroupBtn: $("#add-group"),
        createNewBoardModal: $("#create-new-board"),
        boardTitleCon: $("#boardTitleCon"),
        saveListNameBtn: $("#saveListName"),
        createBoardLink: $(".board-create-link"),
    });

    var theButton = document.getElementById("nav-bar-toggle");

    theButton.style.display = "block";
});
