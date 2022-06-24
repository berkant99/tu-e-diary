<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$query = "SELECT AVG(grade) as average, semester FROM grades WHERE student_id = '{$id}' AND grade > 2 GROUP BY semester";
$avrgBySemester = $conn->query($query);
$data  = array();
while ($row = $avrgBySemester->fetch_assoc()) {
    $data[] = $row;
}
print json_encode($data);
