<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$outgoing_id = $_SESSION['id'];
$searchTerm = $_POST['searchTerm'];
$sql = "SELECT * FROM students WHERE NOT facultyNumber = {$outgoing_id} AND (firstname LIKE '%{$searchTerm}%' OR middlename LIKE '%{$searchTerm}%' OR lastname LIKE '%{$searchTerm}%') ";
$output = "";
$query = $conn->query($sql);
if ($query->num_rows > 0) {
    // require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/listUserController.php';
    $output = "1";
} else {
    $output = 0;
}
echo $output;
