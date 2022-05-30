<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$outgoing_id = $_SESSION['id'];
$searchTerm = $_POST['searchTerm'];
$sql = "SELECT tchr.teacher_id, tchr.email, tp.img, CONCAT(t.title, ' ', tchr.name, ' ', tchr.lastname) as teacher,
SUBSTRING_INDEX(SUBSTRING_INDEX(d.department, '(', -1), ')', 1) as dep FROM teachers tchr
JOIN departments d ON tchr.department_id = d.department_id
JOIN titles t ON tchr.title_id = t.title_id
JOIN t_profile tp ON tchr.teacher_id = tp.teacher_id
WHERE (tchr.email LIKE '%{$searchTerm}%' OR CONCAT(t.title, ' ', tchr.name, ' ', tchr.middlename, ' ', tchr.lastname) LIKE '%{$searchTerm}%'
OR d.department LIKE '%{$searchTerm}%')
ORDER BY tchr.name ASC";
$output = "";
$query = $conn->query($sql);
if ($query->num_rows > 0) {
    require_once 'userData.php';
}
echo $output;
