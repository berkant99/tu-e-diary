<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/PHPMailer/functions.php';
$errorText = '';
$email = $_SESSION['email'];
if (!empty($_POST['verification-code']) && !isset($_GET['send-code-again'])) {
    unset($_SESSION['code-send-msg']);
    $code = $_POST['verification-code'];
    $query = $conn->query("SELECT code FROM st_login WHERE email = '" . $email . "'");
    if ($query->num_rows == 1) {
        $checkCode = $query->fetch_assoc()['code'];
        if ($checkCode == $code) {
            echo "success";
            $conn->query("UPDATE st_login SET code = NULL, email_verified_at = NOW(), code_expire_in = NULL WHERE email= '" . $email . "'");
            $_SESSION['verified'] = TRUE;
            $_SESSION['verification-scs-msg'] = 'Успешно потвърдихте вашия имейл адрес!';
        } else {
            $errorText = $errors['invalid-code'];
        }
    } else {
        $errorText = $errors['error'];
    }
}
if ($errorText != '') {
    echo $errorText;
}


if (isset($_GET['send-code-again']) && !isset($_SESSION['verified'])) {
    $sendToEmail = $_GET['send-code-again'];
    if ($email == $sendToEmail) {
        $updateCode = $conn->query("UPDATE st_login SET code=FLOOR(RAND() * (999999-100000) + 100000), code_expire_in=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE facultyNumber='" . $_SESSION['id'] . "'");
        if ($updateCode == TRUE) {
            $result = $conn->query("SELECT code FROM st_login WHERE email = '" . $sendToEmail . "'")->fetch_assoc();
            $code = $result['code'];
            $isSent = sendCodeToMail($sendToEmail, 'Verify your email address', 'Your email verification code is:', $code);
            if (!$isSent) {
                $errorText = $errors['error'];
            } else {
                $_SESSION['code-send-msg'] = "Изпратен е нов код за потвърждение на адрес " . $sendToEmail;
                header('location: email-verification.php');
            }
        } else {
            $errorText = $errors['error'];
        }
    } else {
        unset($_SESSION['code-send-msg']);
        header('location: email-verification.php');
    }
    if ($errorText != '') {
        $_SESSION['error'] = $errorText;
    }
}
