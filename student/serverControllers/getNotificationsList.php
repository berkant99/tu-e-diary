<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$output = "";
$query = "SELECT n.notification_id, n.from_user, n.to_user, n.is_read,
SUBSTRING_INDEX(n.time,' ', 1) AS date, SUBSTRING_INDEX(n.time,' ', -1) AS time, 
CONCAT(s.firstname,' ',s.lastname) as fullname, nt.text, nt.id
FROM notifications n 
INNER JOIN notification_text nt ON nt.id=n.text_id
INNER JOIN students s ON s.facultyNumber=n.from_user
WHERE n.to_user='{$id}' AND n.is_read = 0 ORDER BY n.time DESC";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = date("d/m/y", strtotime($row['date']));
        $output .= '
<div class="msg">
    <div class="hr-group">
        <li id="'.$row['notification_id'].'" msgFrom="'.$row['from_user'].'" msgTitleId="'.$row['id'].'">' . $row['text'] . ' от ' . $row['fullname'] . '</li>
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
