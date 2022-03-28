<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/PHPMailer/functions.php';
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
                $_SESSION['email-reset'] = $email;
                $code = $conn->query("SELECT code FROM st_login WHERE email='" . $email . "'")->fetch_assoc();
                $key = $code['code'];
                $isSent = sendCodeToMail($email, 'Reset your password', 'Your password reset key is:', $key);
                if ($isSent) {
                    echo "success";
                    $_SESSION['code-sent-msg'] = "Изпратихме ключ за подновяване на паролата до " . $email . "<br/> Ключът е валиден в следващите 30 минути.";
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
}
if ($errorText != '') {
    echo $errorText;
}
