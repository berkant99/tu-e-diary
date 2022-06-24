<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
$query = "SELECT * FROM disciplines WHERE discipline = '{$_POST['discipline-name']}'";
$result = $conn->query($query);
if ($result->num_rows == 0) {
    $query = "INSERT INTO disciplines (discipline) VALUES ('{$_POST['discipline-name']}')";
    $result = $conn->query($query);
    if ($result) {
        echo "success";
    } else {
        $errorText = $errors['error'];
    }
} else {
    $errorText = 'Вече съществува такава дисциплина!';
}
if ($errorText != '') {
    echo $errorText;
}
