<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/PHPMailer/functions.php';

if (isset($_SESSION['send-code'])) {
    if (isset($_SESSION['email-reset'])) {
        $email = $_SESSION['email-reset'];
    } elseif (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }
    $subject = $_SESSION['email-subject'];
    $title = $_SESSION['email-title'];
    $code =  $_SESSION['code-to-send'];
    $isSent = sendCodeToMail($email, $subject, $title, $code);
    if ($isSent) {
        echo "success";
    } else {
        echo $errors['error'];
    }
    unset($_SESSION['send-code']);
    unset($_SESSION['email-subject']);
    unset($_SESSION['email-title']);
    unset($_SESSION['code-to-send']);
}
