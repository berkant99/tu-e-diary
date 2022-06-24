<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$query = "SELECT AVG(gr.grade) as average, SUBSTRING_INDEX(SUBSTRING_INDEX(f.faculty, '(', 1), ')', -1) as faculty FROM grades gr 
JOIN students st ON gr.student_id = st.facultyNumber 
JOIN specialties s ON st.specialty = s.specialty_id 
JOIN departments d ON s.department_id = d.department_id 
JOIN faculties f ON d.faculty_id = f.faculty_id 
WHERE grade > 2 
GROUP BY f.faculty 
ORDER BY average";
$avrgBySemester = $conn->query($query);
$data  = array();
while ($row = $avrgBySemester->fetch_assoc()) {
    $data[] = $row;
}
print json_encode($data);
