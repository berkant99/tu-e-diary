<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
if (isset($_SESSION['id'])) {
    $conn->query("UPDATE t_profile SET last_activity = NOW() WHERE teacher_id = '" . $_SESSION['id'] . "'");
}
