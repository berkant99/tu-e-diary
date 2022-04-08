<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
if (isset($_SESSION['id'])) {
    $conn->query("UPDATE st_login SET last_activity = NOW() WHERE facultyNumber = '" . $_SESSION['id'] . "'");
}
