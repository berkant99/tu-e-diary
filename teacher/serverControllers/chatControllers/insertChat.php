<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$outgoing_id = $_SESSION['id'];
$incoming_id = $_POST['incoming_id'];
$message = $_POST['message'];
if (!empty($message)) {
    $conn->query("INSERT INTO messages (`to`, `from`, `msg`, `time`)
    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', NOW())");
    $query = "SELECT * FROM notifications WHERE from_user = '{$outgoing_id}' AND to_user = '{$incoming_id}' AND text_id = 2";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $updateID = $result->fetch_assoc()['notification_id'];
        $conn->query("UPDATE notifications SET is_read = 0, time = NOW() WHERE notification_id = {$updateID}");
    } else {
        $conn->query("INSERT INTO notifications(text_id, from_user, to_user) VALUES (2,'{$outgoing_id}','{$incoming_id}')");
    }
}
