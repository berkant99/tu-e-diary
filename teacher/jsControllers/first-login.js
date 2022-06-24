import { formCheckInputs, checkPasswords } from "/e-diary/assets/js/jsFunctions.js";
const form = document.getElementById("first-signin-form");
const btn = form.querySelector("button");
const errorStyle = $(".alert-error");
const errorText = $(".alert-error .text");
const warningStyle = $(".alert-warning");

form.onsubmit = (e) => {
    e.preventDefault();
}

function checkForm() {
    let flag = true;
    if (!formCheckInputs("#first-signin-form")) {
        flag = false;
    }
    if (!checkPasswords('newPass', 'repeatPass')) {
        flag = false;
    }
    return flag;
}

btn.onclick = () => {
    if (checkForm()) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "serverControllers/firstLoginController.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        location.href = "grades";
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