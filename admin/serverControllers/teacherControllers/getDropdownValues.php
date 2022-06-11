<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$query = "SELECT department_id, department, SUBSTRING_INDEX(SUBSTRING_INDEX(department, '(', -1), ')', 1) as dep FROM departments ORDER BY department";
$departments = $conn->query($query);
$query = "SELECT * FROM titles";
$titles = $conn->query($query);

