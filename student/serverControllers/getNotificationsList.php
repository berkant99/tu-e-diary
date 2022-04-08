<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$output = "";
$query = "SELECT n.to_user, n.is_read,
SUBSTRING_INDEX(n.time,' ', 1) AS date, SUBSTRING_INDEX(n.time,' ', -1) AS time, 
CONCAT(s.firstname,' ',s.lastname) as fullname, nt.text 
FROM notifications n 
INNER JOIN notification_text nt ON nt.id=n.text_id
INNER JOIN students s ON s.facultyNumber=n.from_user
WHERE to_user='{$id}'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = date("d/m/y", strtotime($row['date']));
        $output .= '
<div class="msg">
    <div class="hr-group">
        <li>' . $row['text'] . ' от ' . $row['fullname'] . '</li>
        <div class="vr-group">
            <div class="date">' . $date . 'г.</div>
            <div class="time">' . $row['time'] . 'ч.</div>
        </div>
    </div>
</div>';
    }
} else {
    $output .= '<div class="msg"><div class="text">Няма нови известия</div></div>';
}
echo $output;
