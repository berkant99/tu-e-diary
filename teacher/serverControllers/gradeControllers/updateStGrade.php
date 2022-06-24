<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$date = date('Y-m-d H:i:s', strtotime($_POST['date']));
$query = "UPDATE grades SET `exam_date`='{$date}', `grade`={$_POST['grade']}, `semester` = {$_POST['semester']}
WHERE discipline_id = {$_POST['disciplineId']} AND student_id = '{$_POST['stId']}'";
$result = $conn->query($query);
if ($result) {
    echo "success";
} else {
    echo "error";
}
