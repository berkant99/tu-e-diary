<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
if (isset($_POST['st-fnum'])) {
    $query = "UPDATE students SET specialty={$_POST['st-specialty-id']}, form_of_education={$_POST['st-eform-id']}, st_group='{$_POST['st-group']}', course='{$_POST['st-course']}' WHERE facultyNumber = '{$_POST['st-fnum']}'";
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
