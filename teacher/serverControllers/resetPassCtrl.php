<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/PHPMailer/functions.php';
$errorText = '';
if (!empty($_POST['newPass-reset']) && !empty($_POST['repeatPass-reset']) && !empty($_POST['key'])) {
    if (isset($_SESSION['email-reset'])) {
        $password = password_hash($_POST['newPass-reset'], PASSWORD_DEFAULT);
        $email = $_SESSION['email-reset'];
        $getId = $conn->query("SELECT teacher_id FROM teachers WHERE email = '" . $email . "'")->fetch_assoc()['teacher_id'];
        $key = $conn->query("SELECT code FROM t_profile WHERE teacher_id = '" . $getId . "'");
        if ($key->num_rows == 1) {
            if ($key->fetch_assoc()['code'] == $_POST['key']) {
                $updatePassword = $conn->query("UPDATE t_profile SET password='" . $password . "', code = NULL, code_expire_in = NULL WHERE teacher_id= '" . $getId . "'");
                if ($updatePassword == TRUE) {
                    echo "success";
                    $_SESSION['password-change-msg'] = 'Успешно променихте вашата парола!';
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
    } else {
        $errorText = $errors['error'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
