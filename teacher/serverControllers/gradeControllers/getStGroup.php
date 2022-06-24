<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$output = '';
$grade = 'null';
$table = '';
$smstrList = '';
function getGrade($grade)
{
    $gradeResult = '';
    switch ($grade):
        case -1:
            $gradeResult = 'Без заверка';
            break;
        case 0:
            $gradeResult = 'Не се явил';
            break;
        case 1:
            $gradeResult = 'Зачита се';
            break;
        case 2:
            $gradeResult = 'Слаб (2)';
            break;
        case 3:
            $gradeResult = 'Среден (3)';
            break;
        case 4:
            $gradeResult = 'Добър (4)';
            break;
        case 5:
            $gradeResult = 'Мн. добър (5)';
            break;
        case 6:
            $gradeResult = 'Отличен (6)';
            break;
    endswitch;
    return $gradeResult;
}
$query = "SELECT * FROM students WHERE (specialty = {$_POST['st-specialty-id']} AND form_of_education = {$_POST['st-eform-id']} AND st_group = {$_POST['st-group']} AND course = {$_POST['st-course']})
ORDER BY facultyNumber";
$result = $conn->query($query);
if ($result->num_rows == 0) {
    $output = "no-students";
} else {
    for ($i = 1; $i <= 10; $i += 1) {
        $smstrList .= "<option value='" . $i . "'>" . $i . "</option>";
    }
    while ($row = $result->fetch_assoc()) {
        $getGrade = $conn->query("SELECT grade, DATE(exam_date) as edate, semester FROM grades WHERE student_id = '{$row['facultyNumber']}' AND discipline_id = '{$_POST['gr-discipline-id']}'");
        if ($getGrade->num_rows == 1) {
            $grade = $getGrade->fetch_assoc();
            $table .= '
            <tr id="' . $row['facultyNumber'] . '">
                <td>' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</td>
                <td>' . $row['facultyNumber'] . '</td>
                <td id="grade"><select id="slct-grade" style="width: 100%;">
                <option value="'.$grade['grade'].'" disabled selected hidden>' . getGrade($grade['grade']) . '</option>
                <option value="-1">Без заверка</option>
                <option value="0">Не се явил</option>
                <option value="1">Зачита се</option>
                <option value="2">Слаб (2)</option>
                <option value="3">Среден (3)</option>
                <option value="4">Добър (4)</option>
                <option value="5">Мн. добър (5)</option>
                <option value="6">Отличен (6)</option>
                </select></td>
                <td id="date"><input name="date" id="date" type="date" value="' . date("Y-m-d", strtotime($grade['edate'])) . '"/></td>
                <td id="smstr"><select id="slct-smstr" style="width: 100%;">
                <option value="'.$grade['semester'].'" disabled selected hidden>' . $grade['semester'] . '</option>
                ' . $smstrList . '
                </select></td>
            </tr>
            ';
        } else {
            $table .= '
            <tr id="' . $row['facultyNumber'] . '">
                <td>' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</td>
                <td>' . $row['facultyNumber'] . '</td>
                <td id="grade"><select id="slct-grade" style="width: 100%;">
                <option value="" disabled selected hidden>Избери</option>
                <option value="-1">Без заверка</option>
                <option value="0">Не се явил</option>
                <option value="1">Зачита се</option>
                <option value="2">Слаб (2)</option>
                <option value="3">Среден (3)</option>
                <option value="4">Добър (4)</option>
                <option value="5">Мн. добър (5)</option>
                <option value="6">Отличен (6)</option>
                </select></td>
                <td id="date"><input name="date" id="date" type="date" value="' . date('Y-m-d') . '"/></td>
                <td id="smstr"><select id="slct-smstr" style="width: 100%;">
                <option value="" disabled selected hidden>Избери</option>
                ' . $smstrList . '
                </select></td>
            </tr>
            ';
        }
    }
    $output .= '<div class="grades-card" style="padding: 20px; height: auto;">
        <legend style="text-align: center;">' . $_POST['gr-discipline'] . ', ' . $_POST['st-specialty'] . ', ' . $_POST['st-eform'] . ', ' . $_POST['st-course'] . ' курс, ' . $_POST['st-group'] . ' група.' . '</legend>
        <table id="grades-table">
            <thead>
                <tr>
                    <td>Студент</td>
                    <td>Факултетен номер</td>
                    <td>Оценка</td>
                    <td>Дата</td>
                    <td>Семестър</td>
                </tr>
            </thead>
            <tbody id="group-grades">
            ' . $table . '
            <tr></tr>
            </tbody>
        </table>
        <div class="object-center">
            <button type="button" id="save-group-grades">Запазване на промените</button>   
        </div>
    </div>';
}
echo $output;
