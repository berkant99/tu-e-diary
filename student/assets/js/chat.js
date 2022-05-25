const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    usersList = document.querySelector(".users-list"),
    msgBox = document.querySelector(".msg-box");

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
    xml.open("POST", "/e-diary/student/serverControllers/chatControllers/search.php", true);
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

setInterval(() => {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/student/serverControllers/chatControllers/userList.php", true);
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
}, 1000);

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
    xml.open("POST", "/e-diary/student/serverControllers/chatControllers/userToChat.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    msgBox.innerHTML = data;
                    $('#start-conversation').css('display', 'none');
                }
                if (data == 0) {
                    msgBox.innerHTML = "";
                    $('#start-conversation').css('display', 'flex');
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("user_id=" + linkId);
}

setInterval(() => {
    if (msgBox.querySelector(".chat-box")) {
        let incomingID = msgBox.querySelector(".incoming_id").value,
            chatBox = msgBox.querySelector(".chat-box"),
            inputField = msgBox.querySelector(".input-field"),
            form = document.querySelector(".typing-area"),
            sendBtn = msgBox.querySelector("button"),
            closeIcon = document.querySelector(".back-icon"),
            status = document.querySelector("header p");
        closeIcon.onclick = () => {
            if ($(window).width() <= 1000) {
                $(".msg-box").css('display', 'none');
                $(".user-box").css('display', 'block');
            }
        }
        $('.input-field').focus(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
            chatBox.classList.remove("active-chat");
        });
        inputField.onkeyup = () => {
            if (inputField.value != "") {
                sendBtn.classList.add("active");
            } else {
                sendBtn.classList.remove("active");
            }
        }
        insertChat(sendBtn, form, chatBox, inputField, incomingID);
        getChat(incomingID, chatBox);
        setStatus(status, incomingID);
    }
}, 1000);

function setStatus(status, id) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/student/serverControllers/chatControllers/getStatus.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    status.innerHTML = data;
                }
                if (data == 0) {
                    status.innerHTML = "";
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("id=" + id);
}

function getChat(id, chatBox) {
        let xml = new XMLHttpRequest();
        xml.open("POST", "/e-diary/student/serverControllers/chatControllers/getChat.php", true);
        xml.onload = () => {
            if (xml.readyState === XMLHttpRequest.DONE) {
                if (xml.status === 200) {
                    let data = xml.response;
                    chatBox.innerHTML = data;
                    if (!chatBox.classList.contains("active-chat")) {
                        scrollToBottom(chatBox);
                    }
                }
            }
        }
        xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xml.send("incoming_id=" + id);
}

function insertChat(btn, form, chatBox, inputField, incomingID) {
    form.onsubmit = (e) => {
        e.preventDefault();
    }
    btn.onclick = () => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/e-diary/student/serverControllers/chatControllers/insertChat.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    inputField.focus();
                    inputField.value = "";
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("incoming_id=" + incomingID + "&message=" + inputField.value);
    }
}

function scrollToBottom(chatBox) {
    chatBox.scrollTop = chatBox.scrollHeight;
    chatBox.onmouseenter = () => {
        chatBox.classList.add("active-chat");
    }
    chatBox.onmouseleave = () => {
        chatBox.classList.remove("active-chat");
    }
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