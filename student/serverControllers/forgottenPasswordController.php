<?php
session_start();
require_once 'dbConnection.php';
require_once 'functions.php';
require_once 'errors.php';
$errorText = '';

if (isset($_POST['forgotten-pass-btn'])) {
    if (!empty($_POST['email'])) {
        $result = executeQuery($conn, "SELECT email_verified_at FROM st_login WHERE email = '" . $_POST['email'] . "'");
        if ($result->num_rows == 1) {
            $result = $result->fetch_assoc();
            $verified = $result['email_verified_at'];
            if ($verified != NULL) {
                $updateCode = executeQuery($conn, "UPDATE st_login SET code='" . dechex(time() + date('dmY')) . "', code_expire_in=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE email='" . $_POST['email'] . "'");
                if ($updateCode == TRUE) {
                    $_SESSION['email-reset'] = $_POST['email'];
                    $code = executeQuery($conn, "SELECT code FROM st_login WHERE email='" . $_POST['email'] . "'")->fetch_assoc();
                    $key = $code['code'];
                    $isSent = sendPasswordResetKey($_POST['email'], $key, EMAIL, PASS);
                    if ($isSent) {
                        $_SESSION['code-sent-msg'] = "Изпратихме ключ за подновяване на паролата до " . $_POST['email'] . "<br/> Ключът е валиден в следващите 30 минути.";
                        header('location: reset-password.php');
                        exit();
                    } else {
                        $errorText = $errors['error'];
                    }
                } else {
                    $errorText = $errors['error'];
                }
            } else {
                $errorText = $errors['email-not-verified'];
            }
        } else {
            $errorText = $errors['email-not-found'];
        }
    } else {
        $errorText = $errors['noinputs'];
    }
    if ($errorText != '') {
        $_SESSION['error'] = $errorText;
    }
}

if (isset($_POST['reset-password-btn'])) {
    if (!empty($_POST['newPass-reset']) && !empty($_POST['repeatPass-reset']) && !empty($_POST['key'])) {
        if (isset($_SESSION['email-reset'])) {
            $key = executeQuery($conn, "SELECT code FROM st_login WHERE email = '" . $_SESSION['email-reset'] . "'");
            if ($key->num_rows == 1) {
                if ($key->fetch_assoc()['code'] == $_POST['key']) {
                    $updatePassword = executeQuery($conn, "UPDATE st_login SET password='" . md5($_POST['newPass-reset']) . "', code = NULL, code_expire_in = NULL WHERE email= '" . $_SESSION['email-reset'] . "'");
                    if ($updatePassword == TRUE) {
                        unset($_SESSION['error']);
                        unset($_SESSION['code-sent-msg']);
                        $_SESSION['password-change-msg'] = 'Успешно променихте вашата парола!';
                        header('location: login-student.php');
                        exit();
                    } else {
                        $errorText = $errors['error'];
                    }
                } else {
                    $errorText = $errors['invalid-key'];
                }
            } else {
                $errorText = $errors['error'];
            }
        }
        else{
        $errorText = $errors['error'];
        }
    } else {
        $errorText = $errors['noinputs'];
    }
    if ($errorText != '') {
        $_SESSION['error'] = $errorText;
    }
}
