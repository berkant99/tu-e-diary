<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/constants.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("<div style='color: red; font-weight: bolder;'> Conection error: " . $conn->connect_error . "</div>");
}
