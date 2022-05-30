<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $output = '';
    $query = "SELECT status from t_profile WHERE teacher_id='{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output = $row['status'] . " now";
    }
    echo $output;
}
