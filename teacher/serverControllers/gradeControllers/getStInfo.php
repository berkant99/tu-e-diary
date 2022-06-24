<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$output = '';
if (isset($_POST['st-fnum'])) {
    $id = $_POST['st-fnum'];
    $disciplneId = $_POST['discipline-id'];
    $query = "SELECT * FROM grades WHERE discipline_id = {$disciplneId} AND student_id = '{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        $query = "SELECT st.firstname, st.middlename, st.lastname, st.st_group, st.course, s.specialty FROM students st
    JOIN specialties s ON st.specialty = s.specialty_id
    WHERE st.facultyNumber = '{$id}'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $output = '
        <div class="hr-group" style="margin: 15px;">
            <div class="st-name">' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</div>
        </div>
        <dl class="dl-horizontal">
            <dt>Факултетен номер:</dt>
            <dd>' . $id . '</dd>
            <dt>Специалност:</dt>
            <dd> ' . $row['specialty'] . '</dd>
            <dt>Група:</dt>
            <dd>' . $row['st_group'] . '</dd>
            <dt>Курс:</dt>
            <dd>' . $row['course'] . '</dd>
            <dt>Дисциплина:</dt>
            <dd>' . $_POST['discipline'] . '</dd>
        </dl>';
        } else {
            $output = "error";
        }
    } else {
        $output = "grade-exist";
    }
    echo $output;
}
