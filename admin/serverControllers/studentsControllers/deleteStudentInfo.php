<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['stId'])) {
    $conn->query("DELETE FROM students WHERE facultyNumber='{$_POST['stId']}'");
}
