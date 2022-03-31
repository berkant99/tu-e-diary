<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
if (isset($_POST['incoming_id'])) {
    $outgoing_id = $_SESSION['id'];
    $incoming_id = $_POST['incoming_id'];
    $output = "";
    $sql = "SELECT * FROM messages msg WHERE (msg.from = {$outgoing_id} AND msg.to = {$incoming_id}) 
    OR (msg.from = {$incoming_id} AND msg.to = {$outgoing_id}) ORDER BY msg.msg_id";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            if ($row['from'] == $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">Все още няма съобщения.<br/>След като започнете разговор с този потребител, съобщенията ще се появят тук.</div>';
    }
    echo $output;
}
