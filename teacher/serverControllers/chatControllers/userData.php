<?php
while ($row = $query->fetch_assoc()) {
    $sql2 = "SELECT * FROM messages WHERE (messages.to = '" . $row['facultyNumber'] . "' OR messages.from = '" . $row['facultyNumber'] . "')
AND (messages.from = '" . $outgoing_id . "' OR messages.to = '" . $outgoing_id . "') ORDER BY msg_id DESC LIMIT 1";
    $query2 = $conn->query($sql2);
    $row2 = ($query2)->fetch_assoc();
    ($query2->num_rows > 0) ? $result = $row2['msg'] : $result = "Нямя съобщения";
    (strlen($result) > 28) ? $msg = substr($result, 0, 28) . '...' : $msg = $result;
    if (isset($row2['from'])) {
        ($outgoing_id == $row2['from']) ? $you = "Вие: " : $you = "";
    } else {
        $you = "";
    }
    $getImgSts = $conn->query("SELECT st.img, st.status FROM st_login st WHERE facultyNumber = '" . $row['facultyNumber'] . "'")->fetch_assoc();
    ($getImgSts['status'] == "Offline") ? $offline = "offline" : $offline = "";
    ($outgoing_id == $row['facultyNumber']) ? $hid_me = "hide" : $hid_me = "";
    $output .= '<a id=' . $row['facultyNumber'] . '>
    <div class="content">
    <img src="/e-diary/profile-pictures/' . $row['img'] . '" alt="profile-pic">
        <div class="details">
            <span>' . $row['student'] . '</span>
            <p>' . $you . $msg . '</p>
        </div>
    </div>
    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i>
    <span class="status-text">' . $getImgSts['status'] . '</span>
    </div>
    </a>';
}
