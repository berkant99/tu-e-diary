<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['disciplineId']) && isset($_POST['stId'])) {
    $conn->query("DELETE FROM grades WHERE discipline_id={$_POST['disciplineId']} AND student_id='{$_POST['stId']}'");
}
