import { formCheckInputs } from "/e-diary/assets/js/jsFunctions.js";
const form = document.getElementById("admin-login-form");
const loginBtn = form.querySelector("button");
const errorStyle = $(".alert-error");
const errorText = $(".alert-error .text");
const infoStyle = $(".alert-info");

form.onsubmit = (e) => {
    e.preventDefault();
}

loginBtn.onclick = () => {
    if (formCheckInputs('#admin-login-form')) {
        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "serverControllers/loginController.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        location.href = "home";
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