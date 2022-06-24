<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$date = date('Y-m-d H:i:s', strtotime($_POST['date']));
$query = "INSERT INTO grades(`discipline_id`, `student_id`, `teacher_id`, `exam_date`, `grade`, `semester`)
VALUES ({$_POST['disciplineId']},'{$_POST['stId']}','{$_SESSION['id']}','{$date}',{$_POST['grade']},{$_POST['semester']})";
$result = $conn->query($query);
if ($result) {
    $query = "SELECT * FROM notifications WHERE from_user = '{$_SESSION['id']}' AND to_user = '{$_POST['stId']}' AND text_id = 1";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $updateID = $result->fetch_assoc()['notification_id'];
        $conn->query("UPDATE notifications SET is_read = 0, time = NOW() WHERE notification_id = {$updateID}");
    } else {
        $conn->query("INSERT INTO notifications(text_id, from_user, to_user) VALUES (1,'{$_SESSION['id']}','{$_POST['stId']}')");
    }
    echo "success";
} else {
    echo "error";
}
