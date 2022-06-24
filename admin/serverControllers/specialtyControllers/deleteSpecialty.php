<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['specId'])) {
    $conn->query("DELETE FROM specialties WHERE specialty_id='{$_POST['specId']}'");
}
