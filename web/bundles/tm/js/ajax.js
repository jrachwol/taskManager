$(document).ready(function () {
    initStartAction();
    loadElements();
    initProfilAction();
    initAccountAction();
    initSettingsAction();
    initTaskAction();
});

var idStart = [
    "btn-login",
    "btn-register"
];
var idAuth = [
    "login_saveLog",
    "register_user_submitRegister",
    "remember_password_submitRem"

];
var idProf = [
    "btn-success",
    "btn-subscribe-list",
    "btn-article",
    "btn-statistic"
];

var idAccount = [
    "btn-config",
    "btn-data-set",
    "btn-theme-change"
];

var idSettings = [
    "data_user_submitData",
    "change_password_submitPswd",
    "account_settings_submitSet",
    "theme_saveTheme",
];

var idTask = [
    "btn-task-subscribe",
    "btn-task-delete",
    "btn-task-unsubscribe",
    "btn-task-success"
];

/////////////////////////////

function initStartAction() {
    for(var i = 0, lenStart = idStart.length; i < lenStart; i++) {
        $("#" + idStart[i]).on("click", startLoginAction);
    }
}
function initAuthentication() {
    for(var i = 0, lenAuth = idAuth.length; i < lenAuth; i++) {
        $("#" + idAuth[i]).on("click", authenticationAction);
    }
}
function initProfilAction() {
    for(var i = 0, lenProf = idProf.length; i < lenProf; i++) {
        $("#" + idProf[i]).on("click", profilAction);
    }
}
function initAccountAction() {
    for(var i = 0, lenAccount = idAccount.length; i < lenAccount; i++) {
        $("#" + idAccount[i]).on("click", accountAction);
    }
}
function initSettingsAction() {
    for(var i = 0, lenSettings = idSettings.length; i < lenSettings ; i++) {
        $("#" + idSettings[i]).on("click", settingsAction);
    }
}
function initTaskAction() {
    for(var i = 0, lenTask = idTask.length; i < lenTask; i++) {
        $("." + idTask[i]).on("click", taskAction);
    }
}

/////////////////////////////

function loadElements() {
    
    if($(".progress").length > 0) {
        $(".progress").remove();
        $('.loader-profil').append("<div class='progress'></div>");
    }
    else {
        $('.loader-profil').append("<div class='progress'></div>");
    }
    $("#option-profil").load("/success-profil");
    $("#account-option").load("/settings");
}

/////////////////////////////

function startLoginAction(e) {

    e.preventDefault();

    if($(".dot").length > 0) {
        $(".dot").remove();
    }
    else {
        $('.loader-start').append("<span class='dot dot_1'></span><span class='dot dot_2'></span><span class='dot dot_3'></span><span class='dot dot_4'></span>");
    }

    var id = $(this).attr("id")
    var url = $(this).attr("href");

    $.ajax({
        method: "GET",
        url: url,
        cache: false,
        success: function (e) {

            if(!$(".message-par").empty()) {
                $(".message-par").remove();
            }

            $(".dot").remove();

            $("#init-content").html(e) ;

        },
        complete: initAuthentication

    });

}

/////////////////////////////

function authenticationAction(e) {
    e.preventDefault();

    var id =$(this).attr("id")

    if(id == "login_saveLog") {
        loginResponse();
    }
    if(id == "register_user_submitRegister") {
        registerResponse()
    }
    if(id == "remember_password_submitRem") {
        rememberResponse()
    }
}

function loginResponse() {

    var url = "/login-check";
    var data = $("form[name=login]").serialize();

    $.ajax({
        data: data,
        method: "POST",
        url: url,
        cache: false,
        success: function (e) {

            if(e == "auth-true") {
                window.location.href = "/user-profil";
            }
            else {
                if(!$(".flash-messages").empty()) {
                    $(".flash-messages").empty();
                }
                $(".flash-messages").load("/flash-message")
            }
        }

    });
}

function registerResponse() {

    var url = "/register";
    var data = $("form[name=register_user]").serialize();

    $.ajax({
        data: data,
        method: "POST",
        url: url,
        cache: false,
        success: function (e) {
            if(!$(".flash-messages").empty()) {
                $(".flash-messages").empty();
            }
            $("#init-content").html(e);
            $(".flash-messages").load("/flash-message")
        }

    });
}

function rememberResponse() {

    var url = "/login";
    var data = $("form[name=remember_password]").serialize();

    $.ajax({
        data: data,
        method: "POST",
        url: url,
        cache: false,
        success: function (e) {

            if(!$(".flash-messages").empty()) {
                $(".flash-messages").empty();
            }
            $("#init-content").html(e);
            $(".flash-messages").load("/flash-message");
        }

    });
}

function profilAction(e) {

    e.preventDefault();

    if($(".progress").length > 0) {
        $(".progress").remove();
        $('.loader-profil').append("<div class='progress'></div>");
    }
    else {
        $('.loader-profil').append("<div class='progress'></div>");
    }

    var id =$(this).attr("id")
    var url = $(this).attr("href");

    $.ajax({
        method: "GET",
        url: url,
        cache: false,
        success: function(e) {

            $("#option-profil").html(e);

        },
        complete: initTaskAction

    });

}


function accountAction(e) {

    e.preventDefault();

    if($(".progress").length > 0) {
        $(".progress").remove();
        $('.loader-profil').append("<div class='progress'></div>");
    }
    else {
        $('.loader-profil').append("<div class='progress'></div>");
    }

    var id =$(this).attr("id")
    var url = $(this).attr("href");

    $.ajax({
        method: "GET",
        url: url,
        cache: false,
        success: function(e) {

            $("#account-option").html(e);

        },
        complete:initSettingsAction

    });

}

function settingsAction(e) {

    e.preventDefault();

    var data = '';

    var id =$(this).attr("id")

    if(id == "data_user_submitData") {
        var url = $("form[name=data_user]").attr("action");
        var data = $("form[name=data_user]").serialize();
    }
    if(id == "change_password_submitPswd") {
        var url = $("form[name=change_password]").attr("action");;
        var data = $("form[name=change_password]").serialize();
    }
    if(id == "account_settings_submitSet") {
        var url = $("form[name=account_settings]").attr("action");
        var data = $("form[name=account_settings]").serialize();
    }
    if(id == "theme_saveTheme") {
        var url = $("form[name=theme]").attr("action");
        var data = $("form[name=theme]").serialize();
        changeTheme();
    }

    $.ajax({
        data: data,
        method: "POST",
        url: url,
        cache: false,
        success: function(e) {

            if(!$(".flash-messages").empty()) {
                $(".flash-messages").empty();
            }

            $("#account-option").html(e);
            $(".flash-messages").load("/flash-message");

        },
        complete:initSettingsAction

    });
}

function taskAction(e) {
    e.preventDefault();
    var taskClass = $(this).attr('class').split(" ", 1);
    var url = $(this).attr("href");

    $.ajax({
        method: "GET",
        url: url,
        cache: false,
        success: function(e) {

            if(!$(".flash-messages").empty()) {
                $(".flash-messages").empty();
            }

            if(e == 'remove-true') {
                $("#task-content").load("/task-page #task-content");
            }

            $(".flash-messages").load("/flash-message");

            $("#option-profil").html(e);

            if(taskClass == 'btn-task-success' || taskClass == 'btn-task-unsubscribe') {
                initTaskAction();
            }

        }

    });

}




