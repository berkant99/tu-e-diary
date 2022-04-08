<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$query = "SELECT n.to_user, n.is_read,
SUBSTRING_INDEX(n.time,' ', 1) AS date, SUBSTRING_INDEX(n.time,' ', -1) AS time, 
CONCAT(s.firstname,' ',s.lastname) as fullname, nt.text 
FROM notifications n 
INNER JOIN notification_text nt ON nt.id=n.text_id
INNER JOIN students s ON s.facultyNumber=n.from_user
WHERE to_user='18621414'";
$result = $conn->query($query);
while($row = $result->fetch_assoc()){
    print_r($row);
}
