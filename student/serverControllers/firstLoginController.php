<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/PHPMailer/functions.php';
$errorText = '';
if (!empty($_POST['newPass']) && !empty($_POST['repeatPass']) && !empty($_POST['email'])) {
    $password = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $result = $conn->query("SELECT email FROM st_login WHERE email = '" . $email . "'");
    if ($result->num_rows == 0) {
        $updateLgnInfo = $conn->query("UPDATE st_login SET password='" . $password . "', email='" . $email . "',
            code=FLOOR(RAND() * (999999-100000) + 100000), code_expire_in=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE facultyNumber='" . $_SESSION['id'] . "'");
        if ($updateLgnInfo == TRUE) {
            $_SESSION['email'] = $email;
            $result = $conn->query("SELECT code FROM st_login WHERE email = '" . $email . "'")->fetch_assoc();
            $code = $result['code'];
            $isSent = sendCodeToMail($email, 'Verify your email address', 'Your email verification code is:', $code);
            if ($isSent) {
                $_SESSION['firstLogin'] = TRUE;
                echo "success";
            } else {
                $errorText = $errors['error'];
            }
        } else {
            $errorText = $errors['error'];
        }
    } else {
        $errorText = $errors['email-exist'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
