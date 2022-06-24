<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$output = '';
$semesterList = '';
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
if (isset($_POST['stId'])) {
    for ($i = 1; $i <= 10; $i += 1) {
        $semesterList .= "<li id='" . $i . "'>" . $i . "</li>";
    }
    $id = $_POST['stId'];
    $query = "SELECT st.firstname, st.middlename, st.lastname, st.st_group, st.course, s.specialty FROM students st
    JOIN specialties s ON st.specialty = s.specialty_id
    WHERE st.facultyNumber = '{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output = '
        <fieldset id="st-info">
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
        </dl>
        </fieldset>';
    } else {
        $output = "error";
    }
    $query = "SELECT * FROM grades WHERE discipline_id = {$_POST['disciplineId']} AND student_id = '{$id}'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output .=
            '<form id="edit-st-grade-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative; margin-top: -15px;">
            <div class="field focused">
                <input type="date" name="exam-st-date" id="e-exam-st-date" value="' . date("Y-m-d", strtotime($row['exam_date'])) . '">
                <label>Дата</label>
                <span></span>
            </div>
            <div class="field focused">
                <input type="text" name="st-semester" id="e-st-semester" style="cursor: pointer; padding-right: 30px;" value="' . $row['semester'] . '" readonly>
                <i class="fa fa-chevron-left"></i>
                <label>Семестър</label>
                <span></span>
                <div class="select-dropdown" id="e-select-st-semester-dropdown" style="margin-top: 15px;">
                    <ul id="e-select-st-semester">
                    ' . $semesterList . '
                    </ul>
                </div>
            </div>
            <div class="field focused">
                <input type="text" name="grade" id="e-grade" style="cursor: pointer; padding-right: 30px;" value="' . getGrade($row['grade']) . '" readonly>
                <input type="hidden" name="grade-id" id="e-grade-id" value="' . $row['grade'] . '">
                <i class="fa fa-chevron-left"></i>
                <label>Оценка</label>
                <span></span>
                <div class="select-dropdown" id="e-select-grade-dropdown">
                    <ul id="e-select-grade" style="max-height: 85px; margin-top: 0px;">
                        <li id="-1">Без заверка</li>
                        <li id="0">Не се явил</li>
                        <li id="1">Зачита се</li>
                        <li id="2">Слаб (2)</li>
                        <li id="3">Среден (3)</li>
                        <li id="4">Добър (4)</li>
                        <li id="5">Мн. добър (5)</li>
                        <li id="6">Отличен (6)</li>
                    </ul>
                </div>
            </div>
            <div class="field object-center">
                <button type="submit" name="edit-st-grade-btn" style="max-width: 350px;">Запази</button>
            </div>
        </form>
        <div class="field object-center">
            <button type="button" id="delete-grade-btn" style="max-width: 350px;">Изтриване на оценката</button>
        </div>';
    } else {
        $output = "error";
    }
}
echo $output;
