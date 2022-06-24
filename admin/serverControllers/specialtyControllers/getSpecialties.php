<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$query = "SELECT s.specialty_id, s.specialty, d.department, ed.degree FROM specialties s 
JOIN departments d ON s.department_id = d.department_id
JOIN e_degrees ed ON s.degree_id = ed.degree_id
ORDER BY specialty";
$specialties = $conn->query($query);
$query = "SELECT department_id, department, SUBSTRING_INDEX(SUBSTRING_INDEX(department, '(', -1), ')', 1) as dep FROM departments ORDER BY department";
$departments = $conn->query($query);
$query = "SELECT * FROM e_degrees";
$degrees = $conn->query($query);
