<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$sql = "SELECT st.facultyNumber, CONCAT(st.firstname, ' ', st.middlename, ' ', st.lastname) as student,
SUBSTRING_INDEX(SUBSTRING_INDEX(d.department, '(', -1), ')', 1) as dep, stl.img FROM students st
JOIN st_login stl ON st.facultyNumber = stl.facultyNumber
JOIN specialties sp ON st.specialty = sp.specialty_id
JOIN departments d ON sp.department_id = d.department_id
ORDER BY st.facultyNumber ASC";
$query = $conn->query($sql);
$output = "";
if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $output .= '<a id=' . $row['facultyNumber'] . '>
    <div class="content">
    <img src="/e-diary/profile-pictures/' . $row['img'] . '" alt="profile-pic">
        <div class="details">
            <span>' . $row['student'] . '</span>
            <p>' . $row['facultyNumber'] . '</p>
        </div>
    </div>
    <div class="department">' . $row['dep'] . '</div>
    </a>';
    }
}
echo $output;
