import { formCheckInputs, filterDropdownList } from "/e-diary/assets/js/jsFunctions.js";
import { checkNames, checkNumber } from "/e-diary/admin/assets/js/js.js";

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

$(document).ready(() => {
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
        $('#find-student').css('display', 'flex');
        $('.msg-box').html(' <div class="vr-group" id="find-student"><i class="fa-solid fa-graduation-cap"></i><div class="text">Потърсете студент...</div></div>');
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
        $('#edit-box').html('<div class="object-center no-grades">Не сте избрали студент!</div>');
    })

    const searchBar = document.querySelector(".search input"),
        searchIcon = document.querySelector(".search button"),
        usersList = document.querySelector(".users-list");

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
        let srchTrm = searchBar.value;
        if (srchTrm != "") {
            searchBar.classList.add("active");
        } else {
            searchBar.classList.remove("active");
        }
        let xml = new XMLHttpRequest();
        xml.open("POST", "/e-diary/admin/serverControllers/studentsControllers/searchStudent.php", true);
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
        xml.send("searchTerm=" + srchTrm);
    }

    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/admin/serverControllers/studentsControllers/getStudentList.php", true);
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

function sendUserLinkId(linkId) {
    const infoBox = document.querySelector(".msg-box");
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/admin/serverControllers/studentsControllers/getStudentInfo.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    infoBox.innerHTML = data;
                    $('#find-student').css('display', 'none');
                    const editStInfo = document.getElementById("edit-st-info"),
                        closeIcon = document.querySelector(".back-icon"),
                        deleteStInfo = document.getElementById("delete-st-info");
                    closeIcon.onclick = () => {
                        if ($(window).width() <= 1000) {
                            $(".msg-box").css('display', 'none');
                            $(".user-box").css('display', 'block');
                        }
                    }
                    editStInfo.onclick = () => {
                        sessionStorage.setItem('edit-id', linkId);
                        $('#search-box').css('display', 'none');
                        $('#edit-box').css('display', 'block');
                        $('#search-btn').toggleClass("active-stgs-btn");
                        $('#edit-btn').toggleClass("active-stgs-btn");
                        getStudentInfo(sessionStorage.getItem('edit-id'));
                    }
                    deleteStInfo.onclick = () => {
                        deleteStudentInfo(linkId);
                    }

                }
                if (data == 0) {
                    infoBox.innerHTML = "";
                    $('#find-student').css('display', 'flex');
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("user_id=" + linkId);
}


function deleteStudentInfo(id) {
    Swal.fire({
        title: 'Внимание',
        text: "Сигурни ли сте, че искате да изтриете този студент?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#175c93',
        confirmButtonText: 'Изтриване',
        cancelButtonText: 'Отказ'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                data: { stId: id },
                url: "/e-diary/admin/serverControllers/studentsControllers/deleteStudentInfo.php",
                success: function () {
                    Swal.fire({
                        title: 'Данните са изтрити',
                        showCancelButton: false,
                        confirmButtonColor: '#175c93',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    })
                }
            });
        }
    })
}

function getStudentInfo(id) {
    $.ajax({
        method: "POST",
        data: { stId: id },
        url: "/e-diary/admin/serverControllers/studentsControllers/getStudentInfo.php",
        success: function (data) {
            $('#edit-box').html(data);
            const form = document.getElementById("edit-student-form"),
                editBtn = form.querySelector("button"),
                errorStyle = $(".alert-error"),
                errorText = $(".alert-error .text"),
                successStyle = $(".alert-success");

            form.onsubmit = (e) => {
                e.preventDefault();
            }

            focusBlurInput('#e-st-specialty', '#e-select-specialty-dropdown');
            focusBlurInput('#e-st-eform', '#e-select-eform-dropdown');
            focusBlurInput('#e-st-group', '#e-select-group-dropdown');
            focusBlurInput('#e-st-course', '#e-select-course-dropdown');

            const Especialty = document.getElementById('е-select-specialty'),
                Estspecialty = document.getElementById('e-st-specialty'),
                Eeform = document.getElementById('е-select-eform'),
                EstEForm = document.getElementById('e-st-eform'),
                EstspecialtyID = document.getElementById('e-st-specialty-id'),
                EstEFormID = document.getElementById('e-st-eform-id'),
                EstCourse = document.getElementById('е-select-course'),
                EstGroup = document.getElementById('е-select-group'),
                Ecourse = document.getElementById('e-st-course'),
                Egroup = document.getElementById('e-st-group');

            Especialty.onclick = function (event) {
                var target = getEventTarget(event);
                Estspecialty.value = target.getAttribute('value');
                EstspecialtyID.value = target.getAttribute('id');
                $('#st-specialty').parent('.field').removeClass('error');
                $('#st-specialty').parent('.field').addClass('focused');
            };

            Eeform.onclick = function (event) {
                var target = getEventTarget(event);
                EstEForm.value = target.innerHTML;
                EstEFormID.value = target.getAttribute('id');
                $('#st-eform').parent('.field').removeClass('error');
                $('#st-eform').parent('.field').addClass('focused');
            };

            EstCourse.onclick = function (event) {
                var target = getEventTarget(event);
                Ecourse.value = target.innerHTML;
                $('#st-course').parent('.field').removeClass('error');
                $('#st-course').parent('.field').addClass('focused');
            };

            EstGroup.onclick = function (event) {
                var target = getEventTarget(event);
                Egroup.value = target.innerHTML;
                $('#st-group').parent('.field').removeClass('error');
                $('#st-group').parent('.field').addClass('focused');
            };

            Estspecialty.onkeyup = function () {
                filterDropdownList(Estspecialty, Especialty);
            }

            editBtn.onclick = () => {
                let formData = new FormData(form);
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/e-diary/admin/serverControllers/studentsControllers/editStudent.php", true);
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
                                errorStyle.fadeIn('fast');
                                errorText.html(data);
                            }
                        }
                    }
                }
                xhr.send(formData);
            }

        }
    });
}

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

focusBlurInput('#st-specialty', '#select-specialty-dropdown');
focusBlurInput('#st-eform', '#select-eform-dropdown');
focusBlurInput('#st-group', '#select-group-dropdown');
focusBlurInput('#st-course', '#select-course-dropdown');

const specialty = document.getElementById('select-specialty'),
    stspecialty = document.getElementById('st-specialty'),
    eform = document.getElementById('select-eform'),
    stEForm = document.getElementById('st-eform'),
    stspecialtyID = document.getElementById('st-specialty-id'),
    stEFormID = document.getElementById('st-eform-id'),
    stCourse = document.getElementById('select-course'),
    stGroup = document.getElementById('select-group'),
    course = document.getElementById('st-course'),
    group = document.getElementById('st-group');

specialty.onclick = function (event) {
    var target = getEventTarget(event);
    stspecialty.value = target.getAttribute('value');
    stspecialtyID.value = target.getAttribute('id');
    $('#st-specialty').parent('.field').removeClass('error');
    $('#st-specialty').parent('.field').addClass('focused');
};

eform.onclick = function (event) {
    var target = getEventTarget(event);
    stEForm.value = target.innerHTML;
    stEFormID.value = target.getAttribute('id');
    $('#st-eform').parent('.field').removeClass('error');
    $('#st-eform').parent('.field').addClass('focused');
};

stCourse.onclick = function (event) {
    var target = getEventTarget(event);
    course.value = target.innerHTML;
    $('#st-course').parent('.field').removeClass('error');
    $('#st-course').parent('.field').addClass('focused');
};

stGroup.onclick = function (event) {
    var target = getEventTarget(event);
    group.value = target.innerHTML;
    $('#st-group').parent('.field').removeClass('error');
    $('#st-group').parent('.field').addClass('focused');
};

stspecialty.onkeyup = function () {
    filterDropdownList(stspecialty, specialty);
}

const form = document.getElementById("add-student-form"),
    addBtn = form.querySelector("button"),
    errorStyle = $(".alert-error"),
    errorText = $(".alert-error .text"),
    successStyle = $(".alert-success");

form.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs('#add-student-form')) {
        flag = false;
    }
    if (!checkNumber('st-fnum', 'fNumError')) {
        flag = false;
    }
    if (!checkNames('st-name', 'nameError')) {
        flag = false;
    }
    if (!checkNames('st-lastname', 'lnameError')) {
        flag = false;
    }
    if (!checkNames('st-middlename', 'mnameError')) {
        flag = false;
    }
    if (!checkNumber('st-egn', 'egnError')) {
        flag = false;
    }
    return flag;
}

addBtn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/e-diary/admin/serverControllers/studentsControllers/addStudent.php", true);
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
