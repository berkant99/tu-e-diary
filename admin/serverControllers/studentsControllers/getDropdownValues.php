<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$query = "SELECT * FROM form_of_education";
$formOfEd = $conn->query($query);
$query = "SELECT specialty_id, specialty, SUBSTRING_INDEX(SUBSTRING_INDEX(specialty, '(', -1), ')', 1) as spec FROM specialties";
$specialties = $conn->query($query);

