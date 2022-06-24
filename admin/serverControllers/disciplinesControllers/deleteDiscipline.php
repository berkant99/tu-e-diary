<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['disciplineId'])) {
    $conn->query("DELETE FROM disciplines WHERE discipline_id={$_POST['disciplineId']}");
}
