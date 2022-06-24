import { formCheckInputs, checkEmail } from "/e-diary/assets/js/jsFunctions.js";
const form = document.getElementById("forgotten-pass-form");
const btn = form.querySelector("button");
const errorStyle = $(".alert-error");
const errorText = $(".alert-error .text");
const warningStyle = $(".alert-warning");

form.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs("#forgotten-pass-form")) {
        flag = false;
    }
    if (!checkEmail('email', 'emailError')) {
        flag = false;
    }
    return flag;
}


btn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "serverControllers/forgottenPassCtrl.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        location.href = "reset-password";
                    }
                    else if (data != '') {
                        warningStyle.css('display', 'none');
                        errorStyle.fadeIn('fast');
                        errorText.html(data);
                    }
                }
            }
        }
        xhr.send(formData);
    }
}