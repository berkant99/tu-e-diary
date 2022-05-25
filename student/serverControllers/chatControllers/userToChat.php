<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $output = '';
    $query = "SELECT s.firstname, s.lastname, sl.img, sl.status from students s
    JOIN st_login sl ON sl.facultyNumber = s.facultyNumber WHERE s.facultyNumber='{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fullname = $row['firstname'] . " " . $row['lastname'];
        $output .= '
        <section class="chat-area">
        <header>
            <img src="../profile-pictures/' . $row['img'] . '" alt="user-icon">
            <div class="details">
                <span>' . $fullname . '</span>
                <p>' . $row['status'] . ' now</p>
            </div>
            <div class="back-icon"><i class="fa-solid fa-xmark"></i></div>
        </header>
        <div class="chat-box">
            <div class="vr-group" style="margin-top: 100px;">
                <div class="loader"></div>
            </div>
        </div>
        <form action="#" class="typing-area">
            <input type="text" class="incoming_id" name="incoming_id" value="' . $id . '" hidden>
            <input type="text" name="message" class="input-field" placeholder="Съобщение..." autocomplete="off">
            <button><i class="fa-solid fa-paper-plane"></i></button>
        </form>
        </section>
        ';
    }
    echo $output;

    /* UPDATE NOTIFICATION FROM UNREAD IN TO READ */
    $query = "SELECT * FROM notifications WHERE from_user = '{$id}' AND to_user = '{$_SESSION["id"]}' AND text_id = 2 AND is_read = 0";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $updateID = $result->fetch_assoc()['notification_id'];
        $conn->query("UPDATE notifications SET is_read = 1 WHERE notification_id = {$updateID}");
    }
}
