<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$outgoing_id = $_SESSION['id'];
$incoming_id = $_POST['incoming_id'];
$message = $_POST['message'];
if (!empty($message)) {
    $conn->query("INSERT INTO messages (`to`, `from`, `msg`, `time`)
    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', NOW())");
}
