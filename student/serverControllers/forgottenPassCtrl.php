<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $result = $conn->query("SELECT email_verified_at FROM st_login WHERE email = '" . $email . "'");
    if ($result->num_rows == 1) {
        $result = $result->fetch_assoc();
        $verified = $result['email_verified_at'];
        if ($verified != NULL) {
            $updateCode = $conn->query("UPDATE st_login SET code='" . dechex(time() + date('dmY')) . "', code_expire_in=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE email='" . $email . "'");
            if ($updateCode == TRUE) {
                $_SESSION['send-code'] = TRUE;
                $_SESSION['email-reset'] = $email;
                $code = $conn->query("SELECT code FROM st_login WHERE email='" . $email . "'")->fetch_assoc();
                $_SESSION['code-to-send'] = $code['code'];
                $_SESSION['email-subject'] = 'Reset your password';
                $_SESSION['email-title'] = 'Your password reset key is:';
                echo "success";
                exit();
            } else {
                $errorText = $errors['error'];
            }
        } else {
            $errorText = $errors['email-not-verified'];
        }
    } else {
        $errorText = $errors['email-not-found'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
