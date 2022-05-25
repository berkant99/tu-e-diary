<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
if (isset($_POST['incoming_id'])) {
    $outgoing_id = $_SESSION['id'];
    $incoming_id = $_POST['incoming_id'];
    $data = array();
    $output = "";
    $sql = "SELECT * FROM messages msg WHERE (msg.from = {$outgoing_id} AND msg.to = {$incoming_id}) 
    OR (msg.from = {$incoming_id} AND msg.to = {$outgoing_id}) ORDER BY msg.msg_id";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $date = date("d F Y", strtotime($row['time']));
            if (array_key_exists($date, $data)) {
                $data[$date][] = array(
                    'msg_id' => $row['msg_id'],
                    'from'      => $row['from'],
                    'msg' => $row['msg'],
                    'time'    => explode(" ", $row['time'])[1],
                );
            } else {
                $data[$date][] = array(
                    'msg_id' => $row['msg_id'],
                    'from'      => $row['from'],
                    'msg' => $row['msg'],
                    'time'    => explode(" ", $row['time'])[1],
                );
            }
        }
        foreach ($data as $date => $value) {
            $output .= '<div class="date">' . $date . '</div>';
            foreach ($value as $key => $msg) {
                if ($msg['from'] == $outgoing_id) {
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p id="'.$msg['msg_id'].'">' . $msg['msg'] . '</p>
                                </div>
                            </div>
                            <div class="time ot">' . $msg['time'] . '</div>';
                } else {
                    $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>' . $msg['msg'] . '</p>
                                </div>
                            </div>
                            <div class="time it">' . $msg['time'] . '</div>';
                }
            }
        }
    } else {
        $output .= '<div class="text">Все още няма съобщения.<br/>След като започнете разговор с този потребител, съобщенията ще се появят тук.</div>';
    }
    echo $output;
}
