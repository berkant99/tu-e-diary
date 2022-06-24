import { formCheckInputs, filterDropdownList } from "/e-diary/assets/js/jsFunctions.js";
import { checkNumber } from "/e-diary/admin/assets/js/js.js";

$(document).ready(() => {
    const addGroupBtn = $('#add-group-btn'),
        addIndividualBtn = $('#add-individual-btn'),
        groupId = $('#add-group-id'),
        individualId = $('#add-individual-id');

    $(addIndividualBtn).css('background-color', '#f5f5f5');

    addGroupBtn.click(() => {
        if ((addGroupBtn).css('background-color') == 'rgb(245, 245, 245)') {
            $(addGroupBtn).css('background-color', '#fff');
            $(addIndividualBtn).css('background-color', '#f5f5f5');
            $(groupId).css('display', 'block');
            $(individualId).css('display', 'none');
        }
    })

    addIndividualBtn.click(() => {
        if ((addIndividualBtn).css('background-color') == 'rgb(245, 245, 245)') {
            $(addIndividualBtn).css('background-color', '#fff');
            $(addGroupBtn).css('background-color', '#f5f5f5');
            $(individualId).css('display', 'block');
            $(groupId).css('display', 'none');
        }
    })
})

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

focusBlurInput('#discipline', '#select-discipline-dropdown');
focusBlurInput('#grade', '#select-grade-dropdown');
focusBlurInput('#st-semester', '#select-st-semester-dropdown');

const discipline = document.getElementById('select-discipline'),
    disciplineVal = document.getElementById('discipline'),
    disciplineId = document.getElementById('discipline-id'),
    form = document.getElementById("add-iGrade-form"),
    addBtn = form.querySelector("button"),
    grade = document.getElementById('select-grade'),
    gradeVal = document.getElementById('grade'),
    gradeId = document.getElementById('grade-id'),
    addForm = document.getElementById("add-st-grade-form"),
    addGradeBtn = addForm.querySelector("button"),
    semester = document.getElementById('select-st-semester'),
    semesterVal = document.getElementById('st-semester');

discipline.onclick = function (event) {
    var target = getEventTarget(event);
    disciplineVal.value = target.innerHTML;
    disciplineId.value = target.getAttribute('id');
    $('#discipline').parent('.field').removeClass('error');
    $('#discipline').parent('.field').addClass('focused');
};

grade.onclick = function (event) {
    var target = getEventTarget(event);
    gradeVal.value = target.innerHTML;
    gradeId.value = target.getAttribute('id');
    $('#grade').parent('.field').removeClass('error');
    $('#grade').parent('.field').addClass('focused');
};

semester.onclick = function (event) {
    var target = getEventTarget(event);
    semesterVal.value = target.innerHTML;
    $('#st-semester').parent('.field').removeClass('error');
    $('#st-semester').parent('.field').addClass('focused');
};

disciplineVal.onkeyup = function () {
    filterDropdownList(disciplineVal, discipline);
}

form.onsubmit = (e) => {
    e.preventDefault();
}

addForm.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs('#add-iGrade-form')) {
        flag = false;
    }
    if (!checkNumber('st-fnum', 'fNumError')) {
        flag = false;
    }
    return flag;
}

addBtn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/e-diary/teacher/serverControllers/gradeControllers/getStInfo.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data == "error") {
                        Swal.fire({
                            title: 'Грешка!',
                            text: "Не е открит студент с този факултетен номер!",
                            showCancelButton: false,
                            confirmButtonColor: '#175c93',
                            icon: 'error'
                        })
                    } else if (data == 'grade-exist') {
                        Swal.fire({
                            title: '',
                            text: "Студент с факултетен номер " + formData.get('st-fnum') + " вече има оценка по " + formData.get('discipline') + ". Желаете ли да редактирате тази оценка?",
                            showCancelButton: true,
                            confirmButtonColor: '#175c93',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Редактиране',
                            cancelButtonText: 'Отказ',
                            icon: 'info'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        discipline: formData.get('discipline'),
                                        disciplineId: formData.get('discipline-id'),
                                        stId: formData.get('st-fnum')
                                    },
                                    url: "/e-diary/teacher/serverControllers/gradeControllers/editStGrade.php",
                                    success: function (data) {
                                        if (data == "error") {
                                            Swal.fire({
                                                title: 'Възникна грешка!',
                                                text: "Моля, опитайте отново!",
                                                showCancelButton: false,
                                                confirmButtonColor: '#175c93',
                                                icon: 'error'
                                            })
                                        } else {
                                            form.style.display = 'none';
                                            $('#next-step').css('display', 'none');
                                            $('#edit-grade').css('display', 'block');
                                            $('#edit-grade').html(data);
                                            const dltGradeBtn = document.getElementById('delete-grade-btn'),
                                                editForm = document.getElementById("edit-st-grade-form"),
                                                editBtn = editForm.querySelector("button"),
                                                grade = document.getElementById('e-select-grade'),
                                                gradeVal = document.getElementById('e-grade'),
                                                gradeId = document.getElementById('e-grade-id'),
                                                semester = document.getElementById('e-select-st-semester'),
                                                semesterVal = document.getElementById('e-st-semester');

                                            editForm.onsubmit = (e) => {
                                                e.preventDefault();
                                            }

                                            grade.onclick = function (event) {
                                                var target = getEventTarget(event);
                                                gradeVal.value = target.innerHTML;
                                                gradeId.value = target.getAttribute('id');
                                                $('#e-grade').parent('.field').removeClass('error');
                                                $('#e-grade').parent('.field').addClass('focused');
                                            };

                                            semester.onclick = function (event) {
                                                var target = getEventTarget(event);
                                                semesterVal.value = target.innerHTML;
                                                $('#e-st-semester').parent('.field').removeClass('error');
                                                $('#e-st-semester').parent('.field').addClass('focused');
                                            };

                                            dltGradeBtn.onclick = () => {
                                                deleteGrade(formData.get('st-fnum'), formData.get('discipline-id'));
                                            }

                                            focusBlurInput('#e-grade', '#e-select-grade-dropdown');
                                            focusBlurInput('#e-st-semester', '#e-select-st-semester-dropdown');
                                            editBtn.onclick = () => {
                                                if (formCheckInputs('#edit-st-grade-form')) {
                                                    let eFormData = new FormData(editForm);
                                                    editGrade(formData, eFormData);
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        })
                    }
                    else if (data != 'error' && data != 'grade-exist') {
                        form.style.display = 'none';
                        $('#next-step').css('display', 'block');
                        $('#st-info').html(data);
                    }
                }
            }
        }
        xhr.send(formData);
    }
}

function editGrade(formData1, formData2) {
    $.ajax({
        method: "POST",
        data: {
            disciplineId: formData1.get('discipline-id'),
            stId: formData1.get('st-fnum'),
            date: formData2.get('exam-st-date'),
            grade: formData2.get('grade-id'),
            semester: formData2.get('st-semester')
        },
        url: "/e-diary/teacher/serverControllers/gradeControllers/updateStGrade.php",
        success: function (data) {
            if (data == "error") {
                Swal.fire({
                    title: 'Възникна грешка!',
                    text: "Моля, опитайте отново!",
                    showCancelButton: false,
                    confirmButtonColor: '#175c93',
                    icon: 'error'
                })
            } else if (data == 'success') {
                Swal.fire({
                    title: 'Данните са обновени!',
                    showCancelButton: false,
                    confirmButtonColor: '#175c93',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                })
            }
        }
    });
}

function deleteGrade(stId, disciplineId) {
    Swal.fire({
        title: 'Внимание',
        text: "Сигурни ли сте, че искате да изтриете тази оценка?",
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
                data: {
                    disciplineId: disciplineId,
                    stId: stId
                },
                url: "/e-diary/teacher/serverControllers/gradeControllers/deleteGrade.php",
                success: function () {
                    Swal.fire({
                        title: 'Оценката е изтрита',
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

addGradeBtn.onclick = () => {
    if (formCheckInputs('#add-st-grade-form')) {
        let formData1 = new FormData(form);
        let formData2 = new FormData(addForm);
        $.ajax({
            method: "POST",
            data: {
                disciplineId: formData1.get('discipline-id'),
                stId: formData1.get('st-fnum'),
                date: formData2.get('exam-st-date'),
                grade: formData2.get('grade-id'),
                semester: formData2.get('st-semester')
            },
            url: "/e-diary/teacher/serverControllers/gradeControllers/insertStGrade.php",
            success: function (data) {
                if (data == "error") {
                    Swal.fire({
                        title: 'Възникна грешка!',
                        text: "Моля, опитайте отново!",
                        showCancelButton: false,
                        confirmButtonColor: '#175c93',
                        icon: 'error'
                    })
                } else if (data == 'success') {
                    Swal.fire({
                        title: 'Оценката е въведена успешно!',
                        showCancelButton: false,
                        confirmButtonColor: '#175c93',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    })
                }
            }
        });
    }
}


/* GROUP GRADE ADD */
focusBlurInput('#gr-discipline', '#gr-select-discipline-dropdown');
focusBlurInput('#st-specialty', '#select-specialty-dropdown');
focusBlurInput('#st-eform', '#select-eform-dropdown');
focusBlurInput('#st-group', '#select-group-dropdown');
focusBlurInput('#st-course', '#select-course-dropdown');

const grdiscipline = document.getElementById('gr-select-discipline'),
    grdisciplineVal = document.getElementById('gr-discipline'),
    grdisciplineId = document.getElementById('gr-discipline-id'),
    grform = document.getElementById("add-groupGrade-form"),
    graddBtn = grform.querySelector("button"),
    specialty = document.getElementById('select-specialty'),
    stspecialty = document.getElementById('st-specialty'),
    eform = document.getElementById('select-eform'),
    stEForm = document.getElementById('st-eform'),
    stspecialtyID = document.getElementById('st-specialty-id'),
    stEFormID = document.getElementById('st-eform-id'),
    stCourse = document.getElementById('select-course'),
    stGroup = document.getElementById('select-group'),
    course = document.getElementById('st-course'),
    group = document.getElementById('st-group');

grdiscipline.onclick = function (event) {
    var target = getEventTarget(event);
    grdisciplineVal.value = target.innerHTML;
    grdisciplineId.value = target.getAttribute('id');
    $('#gr-discipline').parent('.field').removeClass('error');
    $('#gr-discipline').parent('.field').addClass('focused');
};

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

grdisciplineVal.onkeyup = function () {
    filterDropdownList(grdisciplineVal, grdiscipline);
}

grform.onsubmit = (e) => {
    e.preventDefault();
}

graddBtn.onclick = () => {
    if (formCheckInputs('#add-groupGrade-form')) {
        $.ajax({
            method: "POST",
            data: $('#add-groupGrade-form').serialize(),
            url: "/e-diary/teacher/serverControllers/gradeControllers/getStGroup.php",
            success: function (data) {
                if (data == "error") {
                    Swal.fire({
                        title: 'Възникна грешка!',
                        text: "Моля, опитайте отново!",
                        showCancelButton: false,
                        confirmButtonColor: '#175c93',
                        icon: 'error'
                    })
                } else if (data == 'no-students') {
                    Swal.fire({
                        title: 'Възникна грешка!',
                        text: "Не бяха открити студенти!",
                        showCancelButton: false,
                        confirmButtonColor: '#175c93',
                        icon: 'error'
                    })
                }
                else if (data != '') {
                    $('#form-add-groupGrade').css('display', 'none');
                    $('#group-next-step').css('display', 'block');
                    $('#group-next-step').html(data);
                    let saveBtn = document.getElementById('save-group-grades');
                    saveBtn.onclick = () => {
                        let table = document.getElementById('group-grades');
                        let rows = table.querySelectorAll('tr');
                        var result = [];
                        rows.forEach(function (row) {
                            if (row.getAttribute('id') != null) {
                                let facultyNumber = row.getAttribute('id');
                                let examDate = row.querySelector('td[id="date"]').getElementsByTagName('input')[0].value;
                                let smstr = row.querySelector('td[id="smstr"]').getElementsByTagName('select')[0].value;
                                let grade = row.querySelector('td[id="grade"]').getElementsByTagName('select')[0].value;
                                if (smstr != "" && grade != "") {
                                    let obj = {
                                        'fNum': facultyNumber,
                                        'examDate': examDate,
                                        'smstr': smstr,
                                        'grade': grade,
                                    }
                                    result.push(obj);
                                }
                            }
                        });
                        var jsonArr = JSON.stringify(result);
                        $.ajax({
                            type: 'POST',
                            url: '/e-diary/teacher/serverControllers/gradeControllers/insertStGroupGrade.php',
                            data: {
                                arr: jsonArr,
                                discplnId: document.getElementById('gr-discipline-id').value
                            },
                            success: function (data) {
                                if (data == "error") {
                                    Swal.fire({
                                        title: 'Възникна грешка!',
                                        text: "Моля, опитайте отново!",
                                        showCancelButton: false,
                                        confirmButtonColor: '#175c93',
                                        icon: 'error'
                                    })
                                } else if (data == 'success') {
                                    Swal.fire({
                                        title: 'Оценките са запазени успешно!',
                                        showCancelButton: false,
                                        confirmButtonColor: '#175c93',
                                        icon: 'success'
                                    }).then(() => {
                                        location.reload();
                                    })
                                }
                            }
                        });
                    }
                }
            }
        });
    }
}