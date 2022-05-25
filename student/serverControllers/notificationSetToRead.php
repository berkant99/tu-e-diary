<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_POST['id'];
$conn->query("UPDATE notifications SET is_read = 1 WHERE notification_id = {$id}");
