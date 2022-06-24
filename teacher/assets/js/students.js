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
    xml.open("POST", "/e-diary/teacher/serverControllers/studentsControllers/searchStudent.php", true);
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

function sendUserLinkId(linkId) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/teacher/serverControllers/studentsControllers/getStudentInfo.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    tchrBox.innerHTML = data;
                    $('#find-teacher').css('display', 'none');
                    const closeIcon = document.querySelector(".back-icon"),
                        sendMsgBtn = document.getElementById("send-st-msg");
                    closeIcon.onclick = () => {
                        if ($(window).width() <= 1000) {
                            $(".msg-box").css('display', 'none');
                            $(".user-box").css('display', 'block');
                        }
                    }
                    sendMsgBtn.onclick = () => {
                        sessionStorage.setItem('id', linkId);
                        location.href = "messages";
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

$(window).resize(() => {
    if ($(window).width() <= 1000 && $("#group").hasClass('hr-group')) {
        $("#group").toggleClass('hr-group vr-group');
    }
    else if ($(window).width() > 1000 && $("#group").hasClass('vr-group')) {
        $("#group").toggleClass('vr-group hr-group');
        $(".msg-box").css('display', 'block');
        $(".user-box").css('display', 'block');
    }
})

$(document).ready(() => {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/teacher/serverControllers/studentsControllers/getStudentList.php", true);
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

    if ($(window).width() <= 1000 && $("#group").hasClass('hr-group')) {
        $("#group").toggleClass('hr-group vr-group');
    }
    setTimeout(() => {
        $(".user-box .vr-group").css('display', 'none');
        $(".user-box .users-list").css('display', 'block');
    }, 800)

    if (sessionStorage.getItem('id') != null) {
        sendUserLinkId(sessionStorage.getItem('id'));
        sessionStorage.removeItem('id');
        if ($(window).width() <= 1000) {
            $(".msg-box").css('display', 'block');
            $(".user-box").css('display', 'none');
        }
    }
})