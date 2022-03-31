<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$outgoing_id = $_SESSION['id'];
$sql = "SELECT * FROM students WHERE NOT facultyNumber = {$outgoing_id} ORDER BY facultyNumber DESC";
$query = $conn->query($sql);
$output = "";
if ($query->num_rows > 0) {
    require_once "userData.php";
}
echo $output;
