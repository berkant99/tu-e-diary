<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $getInfo = $conn->query("SELECT * FROM teachers WHERE email = '" . $email . "'");
    if ($getInfo->num_rows == 1) {
        $result = $getInfo->fetch_assoc();
        $query = $conn->query("SELECT * FROM t_profile WHERE teacher_id = '" . $result['teacher_id'] . "'");
        $getLastActivity = $query->fetch_assoc()['last_activity'];
        if ($getLastActivity != NULL) {
            $updateCode = $conn->query("UPDATE t_profile SET code='" . dechex(time() + date('dmY')) . "', code_expire_in=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE teacher_id='" . $result['teacher_id'] . "'");
            if ($updateCode == TRUE) {
                $_SESSION['send-code'] = TRUE;
                $_SESSION['email-reset'] = $email;
                $code = $conn->query("SELECT code FROM t_profile WHERE teacher_id='" . $result['teacher_id'] . "'")->fetch_assoc();
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
