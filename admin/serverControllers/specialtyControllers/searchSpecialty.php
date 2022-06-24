<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$searchTerm = $_POST['searchTerm'];
$sql = "SELECT s.specialty_id, s.specialty, d.department, ed.degree FROM specialties s 
JOIN departments d ON s.department_id = d.department_id
JOIN e_degrees ed ON s.degree_id = ed.degree_id
WHERE (s.specialty LIKE '%{$searchTerm}%' OR ed.degree LIKE '%{$searchTerm}%' OR d.department LIKE '%{$searchTerm}%')";
$output = "";
$query = $conn->query($sql);
if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $output .= '<tr>
        <td>' . $row['specialty'] . '</td>
        <td>' . $row['degree'] . '</td>
        <td>' . $row['department'] . '</td>
        <td>
            <div class="object-center">
                <div class="status poor" id="' . $row['specialty_id'] . '" style="cursor: pointer;">Премахване</div>
            </div>
        </td>
    </tr>';
    }
    $output .= "<tr></tr>";
}
echo $output;
