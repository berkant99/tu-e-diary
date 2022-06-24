<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$outgoing_id = $_SESSION['id'];
$sql = "SELECT tchr.teacher_id, tchr.email, tp.img, CONCAT(t.title, ' ', tchr.name, ' ', tchr.lastname) as teacher,
SUBSTRING_INDEX(SUBSTRING_INDEX(department, '(', -1), ')', 1) as dep FROM teachers tchr
JOIN departments d ON tchr.department_id = d.department_id
JOIN titles t ON tchr.title_id = t.title_id
JOIN t_profile tp ON tchr.teacher_id = tp.teacher_id
ORDER BY tchr.name ASC";
$sql = "SELECT st.facultyNumber, CONCAT(st.firstname, ' ', st.middlename, ' ', st.lastname) as student,
SUBSTRING_INDEX(SUBSTRING_INDEX(d.department, '(', -1), ')', 1) as dep, stl.img FROM students st
JOIN st_login stl ON st.facultyNumber = stl.facultyNumber
JOIN specialties sp ON st.specialty = sp.specialty_id
JOIN departments d ON sp.department_id = d.department_id
ORDER BY st.facultyNumber ASC";
$query = $conn->query($sql);
$output = "";
if ($query->num_rows > 0) {
    require_once "userData.php";
}
echo $output;
