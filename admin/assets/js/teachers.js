import { formCheckInputs, checkEmail } from "/e-diary/assets/js/jsFunctions.js";
import { checkNames, checkNumber } from "/e-diary/admin/assets/js/js.js";

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    usersList = document.querySelector(".users-list"),
    tchrBox = document.querySelector(".msg-box");

searchIcon.onclick = () => {
    searchBar.classList.toggle("show");
    searchIcon.classList.toggle("active");
    searchBar.focus();
    if (searchBar.classList.contains("active")) {
        searchBar.value = "";
        searchBar.classList.remove("active");
        $('#usr-not-found-err').css('display', 'none');
    }
}

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;
    if (searchTerm != "") {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/admin/serverControllers/teacherControllers/search.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    usersList.innerHTML = data;
                    $('#usr-not-found-err').css('display', 'none');
                    getUserLinkId();
                }
                if (data == 0) {
                    usersList.innerHTML = "";
                    $('#usr-not-found-err').css('display', 'flex');
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("searchTerm=" + searchTerm);
}

function getUserLinkId() {
    let link = document.getElementById('users-list').getElementsByTagName('a');
    for (var i = 0; i < link.length; i++) {
        let linkId = link.item(i).getAttribute('id');
        link.item(i).addEventListener('click', () => {
            sendUserLinkId(linkId);
            if ($(window).width() <= 1000) {
                $(".msg-box").css('display', 'block');
                $(".user-box").css('display', 'none');
            }
        })
    }
}

function deleteTeacherInfo(id) {
    let alrt = window.confirm('Сигурни ли сте, че искате да изтриете този преподавател?');
    if (alrt) {
        $.ajax({
            method: "POST",
            data: { tchrId: id },
            url: "/e-diary/admin/serverControllers/teacherControllers/deleteTchrInfo.php",
            success: function () {
                location.reload();
            }
        });
    }
}

function sendUserLinkId(linkId) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/admin/serverControllers/teacherControllers/showTchrInfo.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    tchrBox.innerHTML = data;
                    $('#find-teacher').css('display', 'none');
                    const closeIcon = document.querySelector(".back-icon"),
                        sendMsgBtn = document.getElementById("send-tchr-msg"),
                        deleteTchrInfo = document.getElementById("delete-tchr-info");

                    closeIcon.onclick = () => {
                        if ($(window).width() <= 1000) {
                            $(".msg-box").css('display', 'none');
                            $(".user-box").css('display', 'block');
                        }
                    }
                    sendMsgBtn.onclick = () => {
                        sessionStorage.setItem('edit-id', linkId);
                        $('#search-box').css('display', 'none');
                        $('#edit-box').css('display', 'block');
                        $('#search-btn').toggleClass("active-stgs-btn");
                        $('#edit-btn').toggleClass("active-stgs-btn");
                        getTeacherInfo(sessionStorage.getItem('edit-id'));
                    }

                    deleteTchrInfo.onclick = () => {
                        deleteTeacherInfo(linkId);
                    }
                }
                if (data == 0) {
                    tchrBox.innerHTML = "";
                    $('#find-teacher').css('display', 'flex');
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("user_id=" + linkId);
}

function getTeacherInfo(id) {
    $.ajax({
        method: "POST",
        data: { tchrId: id },
        url: "/e-diary/admin/serverControllers/teacherControllers/showTchrInfo.php",
        success: function (data) {
            $('#edit-box').html(data);
            const form = document.getElementById("edit-teacher-form"),
                editBtn = form.querySelector("button"),
                errorStyle = $(".alert-error"),
                errorText = $(".alert-error .text"),
                successStyle = $(".alert-success");

            form.onsubmit = (e) => {
                e.preventDefault();
            }

            focusBlurInput('#e-tchr-title', '#e-select-title-dropdown');
            focusBlurInput('#e-tchr-department', '#e-select-department-dropdown');

            const title = document.getElementById('e-select-title'),
                tchrTitle = document.getElementById('e-tchr-title'),
                department = document.getElementById('e-select-department'),
                tchrDep = document.getElementById('e-tchr-department'),
                tchrTitleID = document.getElementById('e-tchr-title-id'),
                tchrDepID = document.getElementById('e-tchr-department-id');

            title.onclick = function (event) {
                var target = getEventTarget(event);
                tchrTitle.value = target.innerHTML;
                tchrTitleID.value = target.getAttribute('id');
                $('#e-tchr-title').parent('.field').removeClass('error');
                $('#e-tchr-title').parent('.field').addClass('focused');
            };

            department.onclick = function (event) {
                var target = getEventTarget(event);
                tchrDep.value = target.getAttribute('value');
                tchrDepID.value = target.getAttribute('id');
                $('#e-tchr-department').parent('.field').removeClass('error');
                $('#e-tchr-department').parent('.field').addClass('focused');
            };

            function checkForm() {
                let flag = true;
                if (!formCheckInputs('#edit-teacher-form')) {
                    flag = false;
                }
                if (!checkNames('e-tchr-lastname', 'e-lnameError')) {
                    flag = false;
                }
                return flag;
            }

            editBtn.onclick = () => {
                if (checkForm()) {
                    let formData = new FormData(form);
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "/e-diary/admin/serverControllers/teacherControllers/editTchr.php", true);
                    xhr.onload = () => {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                let data = xhr.response;
                                if (data === "success") {
                                    successStyle.css('display', 'flex');
                                    errorStyle.css('display', 'none');
                                    errorText.html("");
                                    setTimeout(function () {
                                        successStyle.fadeOut(1000)
                                        location.reload();
                                    }, 3000);
                                } else if (data != '') {
                                    errorStyle.css('display', 'flex');
                                    errorText.html(data);
                                }
                            }
                        }
                    }
                    xhr.send(formData);
                }
            }
        }
    });
}

const callToActionBtns = document.querySelectorAll(".settings-title");

callToActionBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        callToActionBtns.forEach(f => f.classList.remove('active-stgs-btn'));
        e.target.classList.toggle("active-stgs-btn");
    });
});

const search = $('#search-btn'),
    add = $('#add-btn'),
    edit = $('#edit-btn'),
    searchCard = $('#search-box'),
    addCard = $('#add-box'),
    editCard = $('#edit-box');

search.addClass('active-stgs-btn');

search.on('click', () => {
    searchCard.css('display', 'block');
    addCard.css('display', 'none');
    editCard.css('display', 'none');
    $('#find-teacher').css('display', 'flex');
    $('.msg-box').html(' <div class="vr-group" id="find-teacher"><i class="fa-solid fa-person-chalkboard"></i><div class="text">Потърсете преподавател...</div></div>');
})
add.on('click', () => {
    searchCard.css('display', 'none');
    addCard.css('display', 'block');
    editCard.css('display', 'none');
})
edit.on('click', () => {
    searchCard.css('display', 'none');
    addCard.css('display', 'none');
    editCard.css('display', 'block');
    if (sessionStorage.getItem('edit-id')) {
        sessionStorage.removeItem('edit-id');
    }
    $('#edit-box').html('<div class="object-center no-grades">Не сте избрали преподавател!</div>');
})

$(document).ready(() => {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/admin/serverControllers/teacherControllers/userList.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (!searchBar.classList.contains("active")) {
                    usersList.innerHTML = data;
                    getUserLinkId();
                }
            }
        }
    }
    xml.send();
    setTimeout(() => {
        $(".user-box .vr-group").css('display', 'none');
        $(".user-box .users-list").css('display', 'block');
    }, 800)
})

function focusBlurInput(id, dropdown) {
    $(id).focus(() => {
        $(dropdown).css('display', 'block');
    })

    $(id).blur(() => {
        setTimeout(() => {
            $(dropdown).css('display', 'none');
        }, 200);
    })
}

focusBlurInput('#tchr-title', '#select-title-dropdown');
focusBlurInput('#tchr-department', '#select-department-dropdown');

const title = document.getElementById('select-title'),
    tchrTitle = document.getElementById('tchr-title'),
    department = document.getElementById('select-department'),
    tchrDep = document.getElementById('tchr-department'),
    tchrTitleID = document.getElementById('tchr-title-id'),
    tchrDepID = document.getElementById('tchr-department-id');

title.onclick = function (event) {
    var target = getEventTarget(event);
    tchrTitle.value = target.innerHTML;
    tchrTitleID.value = target.getAttribute('id');
    $('#tchr-title').parent('.field').removeClass('error');
    $('#tchr-title').parent('.field').addClass('focused');
};

department.onclick = function (event) {
    var target = getEventTarget(event);
    tchrDep.value = target.getAttribute('value');
    tchrDepID.value = target.getAttribute('id');
    $('#tchr-department').parent('.field').removeClass('error');
    $('#tchr-department').parent('.field').addClass('focused');
};

const form = document.getElementById("add-teacher-form"),
    addBtn = form.querySelector("button"),
    errorStyle = $(".alert-error"),
    errorText = $(".alert-error .text"),
    successStyle = $(".alert-success");

form.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs('#add-teacher-form')) {
        flag = false;
    }
    if (!checkEmail('tchr-email', 'emailError')) {
        flag = false;
    }
    if (!checkNames('tchr-name', 'nameError')) {
        flag = false;
    }
    if (!checkNames('tchr-lastname', 'lnameError')) {
        flag = false;
    }
    if (!checkNames('tchr-middlename', 'mnameError')) {
        flag = false;
    }
    if (!checkNumber('tchr-egn', 'egnError')) {
        flag = false;
    }
    return flag;
}

addBtn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/e-diary/admin/serverControllers/teacherControllers/addTchr.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        form.reset();
                        successStyle.css('display', 'flex');
                        errorStyle.css('display', 'none');
                        errorText.html("");
                        setTimeout(function () {
                            successStyle.fadeOut(1000);
                            location.reload();
                        }, 3000);
                    } else if (data != '') {
                        errorStyle.fadeIn('fast');
                        errorText.html(data);
                    }
                }
            }
        }
        xhr.send(formData);
    }
}