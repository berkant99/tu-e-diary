function setError(id) {
    $("#" + id).parents('.field').addClass('error');
}

function changeSpanErrorText(inputId, spanId, text) {
    setError(inputId);
    $('#' + spanId).text(text);
}

function isCyrillic(text) {
    return /^[\u0400-\u04FF]+$/.test(text);
}

function isNum(text) {
    return /^[0-9]+$/.test(text);
}

export function checkNames(inputId, errorId) {
    if ($('#' + inputId).val() != '') {
        if (!isCyrillic($('#' + inputId).val())) {
            changeSpanErrorText(inputId, errorId, 'Въведете само на кирилица!');
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

export function checkNumber(inputId, errorId) {
    if ($('#' + inputId).val() != '') {
        if (!isNum($('#' + inputId).val())) {
            changeSpanErrorText(inputId, errorId, 'Въведете само числа!');
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
