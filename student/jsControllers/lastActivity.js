$(document).ready(() => {
    let xml = new XMLHttpRequest();
    setInterval(() => {
        xml.open("POST", "/e-diary/student/serverControllers/updateLastActivity.php", true);
        xml.send();
    }, 1000)
});