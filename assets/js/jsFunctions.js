function setError(id) {
    $("#" + id).parents('.field').addClass('error');
}

function changeSpanErrorText(inputId, spanId, text) {
    setError(inputId);
    $('#' + spanId).text(text);
}

export function formCheckInputs(formId) {
    let flag = true;
    $(formId + " :input[type!=submit]").each(function () {
        var inputValue = $(this).val();
        if (inputValue.trim() == "") {
            setError($(this).attr('id'));
            flag = false;
        }
    });
    return flag;
}

function isPassword(password) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(password);
}

export function checkPasswords(newPass, repeatPass) {
    let flag = true;
    if ($('#' + newPass).val() != "") {
        if (!isPassword($('#' + newPass).val())) {
            changeSpanErrorText(newPass, 'newPassError', 'Въведете валидна парола!');
            flag = false;
        }
    }
    if ($('#' + newPass).val() != "" && $('#' + repeatPass).val() != "") {
        if ($('#' + newPass).val() != $('#' + repeatPass).val()) {
            changeSpanErrorText(repeatPass, 'repeatPassError', 'Двете пароли не съвпадат!');
            flag = false;
        }
    }
    return flag;
}

function isEmail(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

export function checkEmail(inputId, errorId) {
    if ($('#' + inputId).val() != '') {
        if (!isEmail($('#' + inputId).val())) {
            changeSpanErrorText(inputId, errorId, 'Въведете валиден имейл адрес!');
            return false;
        }
        else {
            return true;
        }
    }
    else {
        changeSpanErrorText(inputId, errorId, 'Моля попълнете това поле!');
        return false;
    }
}

export function filterDropdownList(inputId, ul) {
    var filter, li, search, i, txtValue, br;
    filter = inputId.value.toUpperCase();
    li = ul.getElementsByTagName("li");
    br = li.length;
    for (i = 0; i < li.length; i++) {
        search = li[i];
        txtValue = search.textContent || search.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "block";
        } else {
            li[i].style.display = "none";
            br--;
        }
    }
    if (br == 0) {
        document.getElementById('result').style.display = "block";
    }
    else {
        document.getElementById('result').style.display = "none";
    }
}



