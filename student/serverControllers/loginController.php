<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (!empty($_POST['facultyNumber']) && !empty($_POST['password'])) {
    $facultyNumber = $_POST['facultyNumber'];
    $password  = $_POST['password'];
    $query = $conn->query("SELECT * FROM st_login WHERE facultyNumber = '" . $facultyNumber  . "'");
    $result = $query->fetch_assoc();
    if ($query->num_rows == 1 && password_verify($password, $result['password'])) {
        $fullname = $conn->query("SELECT firstname, lastname FROM students WHERE facultyNumber = '" . $facultyNumber  . "'")->fetch_assoc();
        $_SESSION['name'] = $fullname['firstname'] . " " . $fullname['lastname'];
        $_SESSION['id'] = $result['facultyNumber'];
        if ($result['email'] == NULL) {
            $_SESSION['firstLogin'] = FALSE;
        } else {
            $_SESSION['firstLogin'] = TRUE;
        }
        if ($_SESSION['firstLogin'] == TRUE) {
            $result = $conn->query("SELECT * FROM st_login WHERE facultyNumber = '" . $facultyNumber  . "'")->fetch_assoc();
            $_SESSION['email'] = $result['email'];
            $_SESSION['verified'] = $result['email_verified_at'];
            if (!empty($_SESSION['verified'])) {
                $conn->query("UPDATE st_login SET status = 'Active' WHERE facultyNumber = '" .  $_SESSION['id'] . "'");
            }
        }
        echo "success";
    } else {
        $errorText = $errors['invalid'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
