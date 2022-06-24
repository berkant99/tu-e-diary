<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (isset($_POST['delete'])) {
    if (unlink($_SERVER["DOCUMENT_ROOT"] . "/e-diary/profile-pictures/{$_SESSION['img']}")) {
        $update_query = $conn->query("UPDATE t_profile SET img = 'default.jpg' WHERE teacher_id='" . $_SESSION['id'] . "'");
        if ($update_query) {
            $query = $conn->query("SELECT img FROM t_profile WHERE teacher_id = '" . $_SESSION['id'] . "'");
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
                $update_query = $conn->query("UPDATE t_profile SET img = '{$_SESSION['id']}." . $img_ext . "' WHERE teacher_id='" . $_SESSION['id'] . "'");
                if ($update_query) {
                    $query = $conn->query("SELECT * FROM t_profile WHERE teacher_id = '" . $_SESSION['id'] . "'");
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
    $result = $conn->query("SELECT email FROM teachers WHERE email = '" . $email . "'");
    if ($result->num_rows == 0) {
        $updateInfo = $conn->query("UPDATE teachers SET email='" . $email . "' WHERE teacher_id='" . $_SESSION['id'] . "'");
        if ($updateInfo != TRUE) {
            $errorText = $errors['error'];
        } else {
            $_SESSION['email'] = $email;
            echo "success";
        }
    } else {
        $errorText = $errors['email-exist'];
    }
}
if ($errorText != '') {
    echo $errorText;
}
