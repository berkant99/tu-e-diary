<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/studentsControllers/getDropdownValues.php';
$output = '';
if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $query = "SELECT st.firstname, st.middlename, st.lastname, st.st_group, st.course, s.specialty, ed.degree, fed.form_ed, d.department, f.faculty, stl.img FROM students st 
    JOIN specialties s ON st.specialty = s.specialty_id
    JOIN e_degrees ed ON ed.degree_id = s.degree_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN faculties f ON d.faculty_id = f.faculty_id
    JOIN form_of_education fed ON st.form_of_education = fed.form_id
    JOIN st_login stl ON st.facultyNumber = stl.facultyNumber
    WHERE st.facultyNumber = '{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $admission_year = "20" . substr($id, 0, 2);
        $output .= '
    <fieldset id="st-info">
        <div class="hr-group">
            <div class="st-name">' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</div>
            <div class="back-icon"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <dl class="dl-horizontal">
        <div class="object-center">
            <img src="/e-diary/profile-pictures/' . $row['img'] . '" id="output-img" style="width: 180px; height: 180px;">
        </div>
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
            <div class="object-center">
                <button id="send-st-msg" type="button">
                    <div class="hr-group" style="justify-content: center;">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>Съобщение</div>
                </button>
            </div>
        </dl>
    </fieldset>';
    }
    echo $output;
}