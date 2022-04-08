<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/PHPMailer/functions.php';
$errorText = '';
$email = $_SESSION['email'];
if (!empty($_POST['verification-code']) && !isset($_GET['send-code-again'])) {
    $code = $_POST['verification-code'];
    $query = $conn->query("SELECT code FROM st_login WHERE email = '" . $email . "'");
    if ($query->num_rows == 1) {
        $checkCode = $query->fetch_assoc()['code'];
        if ($checkCode == $code) {
            $conn->query("UPDATE st_login SET code = NULL, email_verified_at = NOW(), code_expire_in = NULL WHERE email= '" . $email . "'");
            $_SESSION['verified'] = TRUE;
            $_SESSION['verification-scs-msg'] = 'Успешно потвърдихте вашия имейл адрес!';
            echo "success";
            exit();
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
            $_SESSION['send-code'] = TRUE;
            $code = $conn->query("SELECT code FROM st_login WHERE email='" . $email . "'")->fetch_assoc();
            $_SESSION['code-to-send'] = $code['code'];
            $_SESSION['email-subject'] = 'Verify your email address';
            $_SESSION['email-title'] = 'Your email verification code is:';
            header('location: email-verification.php');
            exit();
        } else {
            $errorText = $errors['error'];
        }
    } else {
        header('location: email-verification.php');
        exit();
    }
}
