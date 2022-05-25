<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
session_start();
$id = $_SESSION['id'];
$output = "";
if (isset($_POST['toggle'])) {
    if ($_POST['toggle'] == 'settings') {
        $output .= "";
    } else if ($_POST['toggle'] == 'information') {
        $query = "SELECT st.firstname, st.middlename, st.lastname, st.st_group, st.course, s.specialty, ed.degree, fed.form_ed, d.department, f.faculty FROM students st 
        JOIN specialties s ON st.specialty = s.specialty_id
        JOIN e_degrees ed ON ed.degree_id = s.degree_id
        JOIN departments d ON s.department_id = d.department_id
        JOIN faculties f ON d.faculty_id = f.faculty_id
        JOIN form_of_education fed ON st.form_of_education = fed.form_id
        WHERE st.facultyNumber = '{$id}'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $admission_year = "20" . substr($id, 0, 2);
            $output .= '
        <fieldset>
            <legend>Информация</legend>
            <dl class="dl-horizontal">
                <dt>Име:</dt>
                <dd>' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</dd>
                <dt>Факултетен номер:</dt>
                <dd>' . $id . '</dd>
                <dt>Специалност:</dt>
                <dd>' . $row['specialty'] . '</dd>
                <dt>ОКС:</dt>
                <dd>' . $row['degree'] . '</dd>
                <dt>Форма на обучение:</dt>
                <dd>' . $row['form_ed'] . '</dd>
                <dt>Група:</dt>
                <dd>' . $row['st_group'] . '</dd> 
                <dt>Курс:</dt>
                <dd>' . $row['course'] . '</dd>
                <dt>Прием:</dt>
                <dd>' . $admission_year . '</dd>
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
