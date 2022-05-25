<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (isset($_POST['delete'])) {
    if (unlink($_SERVER["DOCUMENT_ROOT"] . "/e-diary/profile-pictures/{$_SESSION['img']}")) {
        $update_query = $conn->query("UPDATE st_login SET img = 'default.jpg' WHERE facultyNumber='" . $_SESSION['id'] . "'");
        if ($update_query) {
            $query = $conn->query("SELECT img FROM st_login WHERE facultyNumber = '" . $_SESSION['id'] . "'");
            $result = $query->fetch_assoc();
            $_SESSION['img'] = $result['img'];
            echo "success";
        }
    }
}
if (isset($_FILES['image'])) {
    $img_name = $_FILES['image']['name'];
    $img_type = $_FILES['image']['type'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode);
    $extensions = ["jpeg", "png", "jpg"];
    if (in_array($img_ext, $extensions) === true) {
        $types = ["image/jpeg", "image/jpg", "image/png"];
        if (in_array($img_type, $types) === true) {
            if (move_uploaded_file($tmp_name, $_SERVER["DOCUMENT_ROOT"] . "/e-diary/profile-pictures/{$_SESSION['id']}." . $img_ext)) {
                $update_query = $conn->query("UPDATE st_login SET img = '{$_SESSION['id']}." . $img_ext . "' WHERE facultyNumber='" . $_SESSION['id'] . "'");
                if ($update_query) {
                    $query = $conn->query("SELECT * FROM st_login WHERE facultyNumber = '" . $_SESSION['id'] . "'");
                    $result = $query->fetch_assoc();
                    $_SESSION['img'] = $result['img'];
                    echo "success";
                } else {
                    $errorText = $errors['error'];
                }
            }
        } else {
            $errorText = $errors['invalid-img-type'];
        }
    } else {
        $errorText = $errors['invalid-img-type'];
    }
}
if (!empty($_POST['settings-email'])) {
    $email = $_POST['settings-email'];
    $result = $conn->query("SELECT email FROM st_login WHERE email = '" . $email . "'");
    if ($result->num_rows == 0) {
        $updateInfo = $conn->query("UPDATE st_login SET email='" . $email . "', email_verified_at = NULL,
        code=FLOOR(RAND() * (999999-100000) + 100000), code_expire_in=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE facultyNumber='" . $_SESSION['id'] . "'");
        if ($updateInfo != TRUE) {
            $errorText = $errors['error'];
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['send-code'] = TRUE;
            unset($_SESSION['verified']);
            $code = $conn->query("SELECT code FROM st_login WHERE email='" . $email . "'")->fetch_assoc();
            $_SESSION['code-to-send'] = $code['code'];
            $_SESSION['email-subject'] = 'Verify your email address';
            $_SESSION['email-title'] = 'Your email verification code is:';
            echo "success";
        }
    } else {
        $errorText = $errors['email-exist'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
