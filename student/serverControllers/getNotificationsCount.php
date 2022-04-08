<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$output = "";
$query = "SELECT COUNT(is_read) AS Unread FROM notifications WHERE to_user = '{$id}' AND is_read = 0";
$result = $conn->query($query);
$unreadMsgs = $result->fetch_assoc()["Unread"];
if ($unreadMsgs > 0) {
    $output .= '<div class="unread-msg">' . $unreadMsgs . '</div>';
}
echo $output;
