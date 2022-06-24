<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$query = "SELECT * FROM disciplines";
$disciplines = $conn->query($query);
