<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (!empty($_POST['newPass']) && !empty($_POST['repeatPass'])) {
    $password = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
    $result = $conn->query("UPDATE t_profile SET  password='" . $password . "' WHERE teacher_id = '" . $_SESSION['id'] . "'");
    if ($result) {
        $_SESSION['firstLogin'] = TRUE;
        echo "success";
    } else {
        $errorText = $errors['error'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
