<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['tchrId'])) {
    $conn->query("DELETE FROM teachers WHERE teacher_id='{$_POST['tchrId']}'");
}