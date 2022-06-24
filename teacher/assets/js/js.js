const count = $('#unread-msg-id'),
    dropdown = $("#dropdown-msg-menu-id ul");

$(document).ready(() => {
    getNotificationsList();
    getNotificationsCount();
})

setInterval(() => {
    getNotificationsCount();
}, 500);

$('nav .fa-bell-o').click(() => {
    getNotificationsList();
});

function getNotificationId() {
    let notification = document.getElementById('dropdown-msg-menu-id').getElementsByTagName('li');
    for (var i = 0; i < notification.length; i++) {
        let notificationId = notification.item(i).getAttribute('id');
        let from = notification.item(i).getAttribute('msgFrom');
        let msgTitleId = notification.item(i).getAttribute('msgTitleId');
        notification.item(i).addEventListener('click', () => {
            setToRead(notificationId);
            sessionStorage.setItem('id', from);
            $('.dropdown-msg-menu').slideUp('slow');
            if (msgTitleId == 2) {
                location.href = "messages";
            }
        })
    }
}

function setToRead(id) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/teacher/serverControllers/notificationSetToRead.php", true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("id=" + id);
}

function getNotificationsList() {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/teacher/serverControllers/getNotificationsList.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    dropdown.html(data);
                    getNotificationId();
                }
                if (data == 0) {
                    dropdown.html("");
                }
            }
        }
    }
    xml.send();
}

function getNotificationsCount() {
    let xml = new XMLHttpRequest();
    xml.open("POST", "/e-diary/teacher/serverControllers/getNotificationsCount.php", true);
    xml.onload = () => {
        if (xml.readyState === XMLHttpRequest.DONE) {
            if (xml.status === 200) {
                let data = xml.response;
                if (data != 0) {
                    count.html(data);
                }
                if (data == 0) {
                    count.html("");
                }
            }
        }
    }
    xml.send();
}