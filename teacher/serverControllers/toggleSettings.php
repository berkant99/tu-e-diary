<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$output = "";
if (isset($_POST['toggle'])) {
    if ($_POST['toggle'] == 'settings') {
        $output .= "";
    } else if ($_POST['toggle'] == 'information') {
        $query = "SELECT tchr.email, tchr.cabinet, CONCAT(t.title, ' ', tchr.name, ' ', tchr.middlename, ' ', tchr.lastname) as teacher,
        d.department, f.faculty FROM teachers tchr
        JOIN departments d ON tchr.department_id = d.department_id
        JOIN faculties f ON d.faculty_id = f.faculty_id
        JOIN titles t ON tchr.title_id = t.title_id
        JOIN t_profile tp ON tchr.teacher_id = tp.teacher_id
        WHERE tchr.teacher_id = {$id}";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $output .= '
        <fieldset>
            <legend>Информация</legend>
            <dl class="dl-horizontal">
                <dt>Име:</dt>
                <dd>' . $row['teacher'] . '</dd>
                <dt>ЕГН:</dt>
                <dd>' . $id . '</dd>
                <dt>Имейл:</dt>
                <dd>' . $row['email'] . '</dd>
                <dt>Кабинет:</dt>
                <dd>' . $row['cabinet'] . '</dd>
                <dt>Катедра:</dt>
                <dd>' . $row['department'] . '</dd>
                <dt>Факултет:</dt>
                <dd>' . $row['faculty'] . '</dd>
            </dl>
        </fieldset>';
        }
    }
}
echo $output;
