<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$searchTerm = $_POST['searchTerm'];
$sql = "SELECT * FROM disciplines WHERE discipline LIKE '%{$searchTerm}%'";
$output = "";
$query = $conn->query($sql);
if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $output .= '<tr>
        <td>' . $row['discipline'] . '</td>
        <td>
            <div class="object-center">
                <div class="status poor" id="' . $row['discipline_id'] . '" style="cursor: pointer;">Премахване</div>
            </div>
        </td>
    </tr>';
    }
    $output .= "<tr></tr>";
}
echo $output;
