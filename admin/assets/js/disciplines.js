import { formCheckInputs } from "/e-diary/assets/js/jsFunctions.js";

const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    specialties = document.getElementById("filter-table");


function getId() {
    let remove = document.querySelectorAll(".status");
    remove.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            let id = e.target.getAttribute('id');
            removediscipline(id);
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
    xml.open("POST", "/e-diary/admin/serverControllers/disciplinesControllers/searchDiscipline.php", true);
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

function removediscipline(id) {
    Swal.fire({
        title: 'Внимание',
        text: "Сигурни ли сте, че искате да изтриете тази дисциплина?",
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
                data: { disciplineId: id },
                url: "/e-diary/admin/serverControllers/disciplinesControllers/deleteDiscipline.php",
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


const form = document.getElementById("add-discipline-form"),
    addBtn = form.querySelector("button"),
    errorStyle = $(".alert-error"),
    errorText = $(".alert-error .text"),
    successStyle = $(".alert-success");

form.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs('#add-discipline-form')) {
        flag = false;
    }
    return flag;
}

addBtn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/e-diary/admin/serverControllers/disciplinesControllers/addDiscipline.php", true);
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