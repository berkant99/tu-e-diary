<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$outgoing_id = $_SESSION['id'];
$searchTerm = $_POST['searchTerm'];
$sql = "SELECT st.facultyNumber, CONCAT(st.firstname, ' ', st.middlename, ' ', st.lastname) as student,
SUBSTRING_INDEX(SUBSTRING_INDEX(d.department, '(', -1), ')', 1) as dep, stl.img FROM students st
JOIN st_login stl ON st.facultyNumber = stl.facultyNumber
JOIN specialties sp ON st.specialty = sp.specialty_id
JOIN departments d ON sp.department_id = d.department_id
WHERE (st.facultyNumber LIKE '%{$searchTerm}%' OR CONCAT(st.firstname, ' ', st.middlename, ' ', st.lastname) LIKE '%{$searchTerm}%'
OR d.department LIKE '%{$searchTerm}%')
ORDER BY st.facultyNumber ASC";
$output = "";
$query = $conn->query($sql);
if ($query->num_rows > 0) {
    require_once 'userData.php';
}
echo $output;
