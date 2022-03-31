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

setInterval(function () {
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
                    // let incomingID = msgBox.querySelector(".incoming_id").value;
                    // let chatBox = msgBox.querySelector(".chat-box");
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
    if (msgBox.querySelector(".incoming_id")) {
        let incomingID = msgBox.querySelector(".incoming_id").value;
        let chatBox = msgBox.querySelector(".chat-box");
        getChat(incomingID, chatBox);
    }
}, 100);

function getChat(id, chatBox) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/student/serverControllers/chatControllers/getChat.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    // scrollToBottom();
                }
            }
        }
    }
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("incoming_id=" + id);
}