<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$query = "SELECT AVG(grade) as average FROM grades WHERE grade >= 2";
$avrg = $conn->query($query)->fetch_assoc()['average'];

$query = "SELECT COUNT(*) as student FROM students";
$students = $conn->query($query)->fetch_assoc()['student'];

$query = "SELECT COUNT(*) as teacher FROM teachers";
$teachers = $conn->query($query)->fetch_assoc()['teacher'];

$query = "SELECT COUNT(*) as specialty FROM specialties";
$specialties = $conn->query($query)->fetch_assoc()['specialty'];
