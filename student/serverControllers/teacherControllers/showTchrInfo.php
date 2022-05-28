<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $output = '';
    $query = "SELECT tchr.teacher_id, tchr.email, tchr.img, tchr.cabinet, CONCAT(t.title, ' ', tchr.name, ' ', tchr.middlename, ' ', tchr.lastname) as teacher,
    d.department FROM teachers tchr
    JOIN departments d ON tchr.department_id = d.department_id
    JOIN titles t ON tchr.title_id = t.title_id
    WHERE tchr.teacher_id = {$id}";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output .= '
        <fieldset id="tchr-info">
            <div class="hr-group">
                <div class="tchr-name">' . $row['teacher'] . '</div>
                <div class="back-icon"><i class="fa-solid fa-xmark"></i></div>
            </div>
            <dl class="dl-horizontal">
                <div class="object-center">
                    <img src="/e-diary/profile-pictures/'.$row['img'].'" id="output-img" style="width: 180px; height: 180px;">
                </div>
                <dt>Катедра:</dt>
                <dd>' . $row['department'] . '</dd>
                <dt><i class="fa-solid fa-envelope"></i> </dt>
                <dd>' . $row['email'] . '</dd>
                <dt><i class="fa-solid fa-location-dot"></i> </dt>
                <dd>' . $row['cabinet'] . '</dd>
                <div class="object-center">
                <button id="send-tchr-msg" type="button">
                <div class="hr-group" style="justify-content: center;">
                <i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>Съобщение</div>
                </button>
                </div>
            </dl>
        </fieldset>';
    }
    echo $output;
}
