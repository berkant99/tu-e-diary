<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (isset($_POST['tchr-egn'])) {
    $query = "UPDATE teachers SET lastname='{$_POST['tchr-lastname']}', department_id={$_POST['tchr-department-id']}, title_id='{$_POST['tchr-title-id']}', cabinet='{$_POST['tchr-cabinet']}' WHERE teacher_id = '{$_POST['tchr-egn']}'";
    $result = $conn->query($query);
    if ($result) {
        echo "success";
    } else {
        $errorText = $errors['error'];
    }
}
if ($errorText != '') {
    echo $errorText;
}