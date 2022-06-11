<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password  = $_POST['password'];
    $query = $conn->query("SELECT * FROM tb_admin WHERE username = '" . $username  . "'");
    $result = $query->fetch_assoc();
    if ($query->num_rows == 1 && password_verify($password, $result['password'])) {
        $_SESSION['name'] = "Администратор";
        $_SESSION['id'] = $result['username'];
        echo "success";
    } else {
        $errorText = $errors['invalid'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
