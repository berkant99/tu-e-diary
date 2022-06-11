<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/studentsControllers/getDropdownValues.php';
$output = '';
$specList = '';
$eformList = '';
$courseList = '';
$groupList = '';
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
                <button id="edit-st-info" type="button">
                    <div class="hr-group" style="justify-content: center;">
                    <i class="fa-solid fa-user-pen" style="margin-right: 10px;"></i>Редактиране</div>
                </button>
            </div>
            <div class="object-center">
            <button id="delete-st-info" type="button">
                <div class="hr-group" style="justify-content: center;">
                <i class="fa-solid fa-trash-can" style="margin-right: 10px;"></i>Изтриване</div>
            </button>
            </div>
        </dl>
    </fieldset>';
    }
    echo $output;
}

if (isset($_POST['stId'])) {
    $id = $_POST['stId'];
    while ($row1 = $specialties->fetch_assoc()) {
        $specList .= "<li id='" . $row1['specialty_id'] . "' value='" . $row1["spec"] . "'>" . $row1["specialty"] . "</li>";
    }
    while ($row2 = $formOfEd->fetch_assoc()) {
        $eformList .= "<li id='" . $row2['form_id'] . "'>" . $row2["form_ed"] . "</li>";
    }
    for ($i = 1; $i <= 10; $i += 1) {
        $groupList .= "<li id='" . $i . "'>" . $i . "</li>";
    }
    for ($i = 1; $i <= 5; $i += 1) {
        $courseList .= "<li id='" . $i . "'>" . $i . "</li>";
    }
    $query = "SELECT st.facultyNumber, st.firstname, st.middlename, st.lastname, st.st_group, st.course, st.specialty, st.form_of_education, SUBSTRING_INDEX(SUBSTRING_INDEX(s.specialty, '(', -1), ')', 1) as spec, fed.form_ed  FROM students st 
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
        $output = '<div class="object-center" style="height: auto;">
    <div class="container">
        <div class="wrapper" style="box-shadow: none; background: none;">
            <div class="form-title">Редактиране на данни на студент</div>
            <div class="alert alert-success" style="display: none;">
                <div class="icon">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                </div>
                <div class="text">
                    Успешна промяна!
                </div>
                <div></div>
            </div>
            <div class="alert alert-error" style="display: none;">
                <div class="icon">
                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                </div>
                <div class="text"></div>
                <div></div>
            </div>
            <form id="edit-student-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                <div class="hr-group" style="justify-content: center;">
                    <div class="right-box" style="min-width: 300px; margin-right: 20px;">
                        <div class="field focused">
                            <input type="text" name="st-name" id="st-name" maxlength="15" value="' . $row['firstname'] . '" readonly>
                            <label>Име</label>
                            <span id="nameError"></span>
                        </div>
                        <div class="field focused">
                            <input type="text" name="st-middlename" id="st-middlename" maxlength="15" value="' . $row['middlename'] . '" readonly>
                            <label>Презиме</label>
                            <span id="mnameError"></span>
                        </div>
                        <div class="field focused">
                            <input type="text" name="st-lastname" id="st-lastname" maxlength="50" value="' . $row['lastname'] . '" readonly>
                            <label>Фамилия</label>
                            <span id="lnameError"></span>
                        </div>
                        <div class="field focused">
                            <input type="text" name="st-fnum" id="e-st-fnum" maxlength="10" value="' . $row['facultyNumber'] . '" readonly>
                            <label>Факултетен номер</label>
                            <span id="fNumError"></span>
                        </div>
                    </div>
                    <div class="left-box" style="min-width: 300px;">
                        <div class="field focused">
                            <input type="text" name="st-specialty" id="e-st-specialty" style="cursor: pointer; padding-right: 30px;" value="' . $row['spec'] . '" readonly>
                            <input type="hidden" name="st-specialty-id" id="e-st-specialty-id" value="' . $row['specialty'] . '">
                            <i class="fa fa-chevron-left"></i>
                            <label>Специалност</label>
                            <span></span>
                            <div class="select-dropdown" id="e-select-specialty-dropdown">
                                <ul id="е-select-specialty">
                                ' . $specList . '
                                </ul>
                            </div>
                        </div>
                        <div class="field focused">
                            <input type="text" name="st-eform" id="e-st-eform" style="cursor: pointer; padding-right: 30px;" value="' . $row['form_ed'] . '" readonly>
                            <input type="hidden" name="st-eform-id" id="e-st-eform-id" value="' . $row['form_of_education'] . '">
                            <i class="fa fa-chevron-left"></i>
                            <label>Форма на обучение</label>
                            <span></span>
                            <div class="select-dropdown" id="e-select-eform-dropdown">
                                <ul id="е-select-eform">
                                ' . $eformList . '
                                </ul>
                            </div>
                        </div>
                        <div class="field focused">
                            <input type="text" name="st-group" id="e-st-group" style="cursor: pointer; padding-right: 30px;" value="' . $row['st_group'] . '" readonly>
                            <i class="fa fa-chevron-left"></i>
                            <label>Група</label>
                            <span></span>
                            <div class="select-dropdown" id="e-select-group-dropdown">
                                <ul id="е-select-group">
                                ' . $groupList . '
                                </ul>
                            </div>
                        </div>
                        <div class="field focused">
                            <input type="text" name="st-course" id="e-st-course" style="cursor: pointer; padding-right: 30px;" value="' . $row['course'] . '" readonly>
                            <i class="fa fa-chevron-left"></i>
                            <label>Курс</label>
                            <span></span>
                            <div class="select-dropdown" id="e-select-course-dropdown">
                                <ul id="е-select-course">
                                ' . $courseList . '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <button type="submit" name="edit-student-btn">Запазване на промените</button>
                </div>
            </form>
        </div>
    </div>
</div>';
    }
    echo $output;
}
