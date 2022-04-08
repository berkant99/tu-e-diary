$(document).ready(() => {
    const count = $('#unread-msg-id'),
        dropdown = $("#dropdown-msg-menu-id ul");
    setInterval(() => {
        let xml = new XMLHttpRequest();
        xml.open("POST", "/e-diary/student/serverControllers/getNotificationsCount.php", true);
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
    }, 500);
    setInterval(() => {
        let xml = new XMLHttpRequest();
        xml.open("POST", "/e-diary/student/serverControllers/getNotificationsList.php", true);
        xml.onload = () => {
            if (xml.readyState === XMLHttpRequest.DONE) {
                if (xml.status === 200) {
                    let data = xml.response;
                    if (data != 0) {
                        dropdown.html(data);
                    }
                    if (data == 0) {
                        dropdown.html("");
                    }
                }
            }
        }
        xml.send();
    }, 500);
    // console.log(count.text());
})

