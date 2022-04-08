<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $output = '';
    $query = "SELECT s.firstname, s.lastname, sl.status from students s
    JOIN st_login sl ON sl.facultyNumber = s.facultyNumber WHERE s.facultyNumber='{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fullname = $row['firstname'] . " " . $row['lastname'];
        $output .= '
        <section class="chat-area">
        <header>
            <img src="../assets/images/user-icon.jpg" alt="user-icon">
            <div class="details">
                <span>' . $fullname . '</span>
                <p>' . $row['status'] . ' now</p>
            </div>
            <div class="back-icon"><i class="fa-solid fa-xmark"></i></div>
        </header>
        <div class="chat-box">
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
}
