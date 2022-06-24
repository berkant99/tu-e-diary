import { formCheckInputs, filterDropdownList } from "/e-diary/assets/js/jsFunctions.js";

const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    specialties = document.getElementById("filter-table");


function getId() {
    let remove = document.querySelectorAll(".status");
    remove.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            let id = e.target.getAttribute('id');
            removeSpecialty(id);
        });
    })
}

getId();

searchIcon.onclick = () => {
    searchBar.classList.toggle("show");
    searchIcon.classList.toggle("active");
    searchBar.focus();
    if (searchBar.classList.contains("active")) {
        searchBar.value = "";
        searchBar.classList.remove("active");
        $('#not-found').css('display', 'none');
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
    xml.open("POST", "/e-diary/admin/serverControllers/specialtyControllers/searchSpecialty.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    specialties.innerHTML = data;
                    $('#not-found').css('display', 'none');
                    getId();
                }
                if (data == 0) {
                    specialties.innerHTML = "";
                    $('#not-found').css('display', 'flex');
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("searchTerm=" + srchTrm);
}

function removeSpecialty(id) {
    Swal.fire({
        title: 'Внимание',
        text: "'Сигурни ли сте, че искате да изтриете тази специалност?'",
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
                data: { specId: id },
                url: "/e-diary/admin/serverControllers/specialtyControllers/deleteSpecialty.php",
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

const callToActionBtns = document.querySelectorAll(".settings-title");

callToActionBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        callToActionBtns.forEach(f => f.classList.remove('active-stgs-btn'));
        e.target.classList.toggle("active-stgs-btn");
    });
});

const search = $('#search-btn'),
    add = $('#add-btn'),
    searchCard = $('#search-box'),
    addCard = $('#add-box');

search.addClass('active-stgs-btn');

search.on('click', () => {
    searchCard.css('display', 'block');
    addCard.css('display', 'none');
})

add.on('click', () => {
    searchCard.css('display', 'none');
    addCard.css('display', 'block');
})


const department = document.getElementById('select-department'),
    specDep = document.getElementById('spec-department'),
    specDepID = document.getElementById('spec-department-id'),
    degree = document.getElementById('select-degree'),
    specDegree = document.getElementById('spec-degree'),
    specDegreeID = document.getElementById('spec-degree-id'),
    form = document.getElementById("add-specialty-form"),
    addBtn = form.querySelector("button"),
    errorStyle = $(".alert-error"),
    errorText = $(".alert-error .text"),
    successStyle = $(".alert-success");

department.onclick = function (event) {
    var target = getEventTarget(event);
    specDep.value = target.getAttribute('value');
    specDepID.value = target.getAttribute('id');
    $('#spec-department').parent('.field').removeClass('error');
    $('#spec-department').parent('.field').addClass('focused');
};


degree.onclick = function (event) {
    var target = getEventTarget(event);
    specDegree.value = target.innerHTML;
    specDegreeID.value = target.getAttribute('id');
    $('#spec-degree').parent('.field').removeClass('error');
    $('#spec-degree').parent('.field').addClass('focused');
};


specDep.onkeyup = function () {
    filterDropdownList(specDep, department);
}

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
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

focusBlurInput('#spec-department', '#select-department-dropdown');
focusBlurInput('#spec-degree', '#select-degree-dropdown');

form.onsubmit = (e) => {
    e.preventDefault();
}

function setError(id) {
    $("#" + id).parents('.field').addClass('error');
}

function changeSpanErrorText(inputId, spanId, text) {
    setError(inputId);
    $('#' + spanId).text(text);
}

function isSpecialty(text) {
    return /^[\u0400-\u04FF\s\(\)]+$/.test(text);
}

function checkSpecialty(inputId, errorId) {
    if ($('#' + inputId).val() != '') {
        if (!isSpecialty($('#' + inputId).val())) {
            changeSpanErrorText(inputId, errorId, 'Въведете специалност във валиден формат!');
            return false;
        }
        else {
            return true;
        }
    }
    else {
        changeSpanErrorText(inputId, errorId, 'Моля попълнете това поле!');
        return false;
    }
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs('#add-specialty-form')) {
        flag = false;
    }
    if (!checkSpecialty('specialty-name', 'specialtyError')) {
        flag = false;
    }
    return flag;
}


addBtn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/e-diary/admin/serverControllers/specialtyControllers/addSpecialty.php", true);
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