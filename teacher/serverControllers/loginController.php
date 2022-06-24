<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password  = $_POST['password'];
    $query = $conn->query("SELECT * FROM teachers WHERE email = '" . $email  . "'");
    if ($query->num_rows == 1) {
        $result = $query->fetch_assoc();
        $query = $conn->query("SELECT * FROM t_profile WHERE teacher_id = '" . $result['teacher_id']  . "'");
        $getInfo = $query->fetch_assoc();
        if (password_verify($password, $getInfo['password'])) {
            $_SESSION['name'] = $result['name'] . " " . $result['lastname'];
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $result['teacher_id'];
            $_SESSION['img'] = $getInfo['img'];
            if ($getInfo['last_activity'] == NULL) {
                $_SESSION['firstLogin'] = FALSE;
            } else {
                $_SESSION['firstLogin'] = TRUE;
            }
            echo "success";
        } else {
            $errorText = $errors['invalid'];
        }
    } else {
        $errorText = $errors['invalid'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
