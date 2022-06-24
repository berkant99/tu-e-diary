import { formCheckInputs, checkEmail } from "/e-diary/assets/js/jsFunctions.js";
const form = document.getElementById("teacher-login-form");
const loginBtn = form.querySelector("button");
const errorStyle = $(".alert-error");
const errorText = $(".alert-error .text");
const infoStyle = $(".alert-info");

form.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs("#teacher-login-form")) {
        flag = false;
    }
    if (!checkEmail('email', 'emailError')) {
        flag = false;
    }
    return flag;
}

loginBtn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "serverControllers/loginController.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        location.href = "grades";
                        loginBtn.disabled = true;
                    } else if (data != '') {
                        infoStyle.css('display', 'none');
                        errorStyle.fadeIn('fast');
                        errorText.html(data);
                    }
                }
            }
        }
        xhr.send(formData);
    }
}