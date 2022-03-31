import { formCheckInputs } from "/e-diary/assets/js/jsFunctions.js";
const form = document.getElementById("email-verification-form");
const btn = form.querySelector("button");
const errorStyle = $(".alert-error");
const errorText = $(".alert-error .text");
const successStyle = $(".alert-success");

$(document).ready(function () {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "serverControllers/sendCodeToMailCtrl.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data === "success") {
                    errorStyle.css('display', 'none');
                    successStyle.fadeIn('fast');
                }
                else if (data != '') {
                    successStyle.css('display', 'none');
                    errorStyle.fadeIn('fast');
                    errorText.html(data);
                }
            }
        }
    }
    xhr.send();
})

form.onsubmit = (e) => {
    e.preventDefault();
}

btn.onclick = () => {
    if (formCheckInputs("#email-verification-form")) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "serverControllers/emailVerficationCtrl.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        location.href = "index.php";
                    }
                    else if (data != '') {
                        successStyle.css('display', 'none');
                        errorStyle.fadeIn('fast');
                        errorText.html(data);
                    }
                }
            }
        }
        xhr.send(formData);
    }
}