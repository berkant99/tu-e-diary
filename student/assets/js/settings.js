$(document).ready(() => {
    const settingsBtn = $('#settings-btn'),
        infoBtn = $('#info-btn'),
        settings = $('#settings-id'),
        info = $('#info-id'),
        deleteBtn = $('#delete-img-btn');

    $(infoBtn).css('background-color', '#f5f5f5');
    // toggleSettings("settings", settings);

    settingsBtn.click(() => {
        if ((settingsBtn).css('background-color') == 'rgb(245, 245, 245)') {
            $(settingsBtn).css('background-color', '#fff');
            $(infoBtn).css('background-color', '#f5f5f5');
            $(settings).css('display', 'block');
            $(info).css('display', 'none');
            // toggleSettings("settings", settings);
        }
    })

    infoBtn.click(() => {
        if ((infoBtn).css('background-color') == 'rgb(245, 245, 245)') {
            $(infoBtn).css('background-color', '#fff');
            $(settingsBtn).css('background-color', '#f5f5f5');
            $(info).css('display', 'block');
            $(settings).css('display', 'none');
            toggleSettings("information", info);
        }
    })

    if ($(window).width() <= 800 && $("#btn-group").hasClass('hr-group')) {
        $("#btn-group").toggleClass('hr-group vr-group');
    }

    deleteBtn.click(() => {
        $.ajax({
            method: "POST",
            data: { delete: 1 },
            url: "serverControllers/changeSettings.php",
            success: function (data) {    // success callback function
                if (data === "success") {
                    window.location.href = "/e-diary/student/settings";
                }
            }
        });
    })
})

$(window).resize(() => {
    if ($(window).width() <= 800 && $("#btn-group").hasClass('hr-group')) {
        $("#btn-group").toggleClass('hr-group vr-group');
    }
    else if ($(window).width() > 800 && $("#btn-group").hasClass('vr-group')) {
        $("#btn-group").toggleClass('vr-group hr-group');

    }
})

function toggleSettings(toSend, toDisplay) {
    $.ajax({
        method: "POST",
        data: { toggle: toSend },
        url: "serverControllers/toggleSettings.php",
        success: function (data) {    // success callback function
            toDisplay.html(data);
        }
    });
}

import { checkEmail } from "/e-diary/assets/js/jsFunctions.js";
const form = document.getElementById("student-settings-form"),
    btn = form.querySelector("button"),
    errorStyle = $(".alert-error"),
    errorText = $(".alert-error .text");

form.onsubmit = (e) => {
    e.preventDefault();
}

function loadFile(event) {
    var image = document.getElementById("output-img");
    image.src = URL.createObjectURL(event.target.files[0]);
};

var imgFile = document.getElementById("file");
imgFile.onchange = (e) => {
    loadFile(e);
    let formData = new FormData(document.getElementById("img-form"));
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "serverControllers/changeSettings.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data != 'success') {
                    errorStyle.fadeIn('fast');
                    errorText.html(data);
                }
                else if (data === "success") {
                    window.location.href = "/e-diary/student/settings";
                }
            }
        }
    }
    xhr.send(formData);
}

btn.onclick = () => {
    if (checkEmail('settings-email', 'settingsEmailError')) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "serverControllers/changeSettings.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        window.location.href = "/e-diary/student/home";
                    }
                    else if (data != '') {
                        errorStyle.fadeIn('fast');
                        errorText.html(data);
                    }
                }
            }
        }
        xhr.send(formData);
    }
}