<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$discplnId = $_POST['discplnId'];
$tchrId = $_SESSION['id'];
$arr = json_decode($_POST['arr'], true);
$output = '';
foreach ($arr as $item) {
    $fNum = $item['fNum'];
    $date = date('Y-m-d H:i:s', strtotime($item['examDate']));
    $smstr = $item['smstr'];
    $grade = $item['grade'];
    $query = "SELECT * FROM grades WHERE discipline_id = {$discplnId} AND student_id = '{$fNum}'";
    $rslt = $conn->query($query);
    if ($rslt->num_rows == 0) {
        $query = "INSERT INTO grades(`discipline_id`, `student_id`, `teacher_id`, `exam_date`, `grade`, `semester`)
VALUES ({$discplnId},'{$fNum}','{$tchrId}','{$date}',{$grade},{$smstr})";
        $result = $conn->query($query);
        if ($result) {
            $query = "SELECT * FROM notifications WHERE from_user = '{$tchrId}' AND to_user = '{$fNum}' AND text_id = 1";
            $result = $conn->query($query);
            if ($result->num_rows == 1) {
                $updateID = $result->fetch_assoc()['notification_id'];
                $conn->query("UPDATE notifications SET is_read = 0, time = NOW() WHERE notification_id = {$updateID}");
            } else {
                $conn->query("INSERT INTO notifications(text_id, from_user, to_user) VALUES (1,'{$tchrId}','{$fNum}')");
            }
            $output = "success";
        } else {
            $output = "error";
        }
    } else {
        $query = "UPDATE grades SET exam_date='{$date}', grade={$grade}, semester={$smstr} WHERE discipline_id = {$discplnId} AND student_id = '{$fNum}'";
        $result = $conn->query($query);
        if ($result) {
            $output = "success";
        } else {
            $output = "error";
        }
    }
}
echo $output;
