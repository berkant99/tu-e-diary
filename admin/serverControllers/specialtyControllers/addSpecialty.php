<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
$errorText = '';
$query = "SELECT * FROM specialties WHERE (specialty = '{$_POST['specialty-name']}' AND department_id = {$_POST['spec-department-id']} AND degree_id = {$_POST['spec-degree-id']})";
$result = $conn->query($query);
if ($result->num_rows == 0) {
    $query = "INSERT INTO specialties (specialty, department_id, degree_id) VALUES ('{$_POST['specialty-name']}',{$_POST['spec-department-id']},{$_POST['spec-degree-id']})";
    $result = $conn->query($query);
    if ($result) {
        echo "success";
    } else {
        $errorText = $errors['error'];
    }
} else {
    $errorText = "Вече съществува такава специалност!";
}
if ($errorText != '') {
    echo $errorText;
}
