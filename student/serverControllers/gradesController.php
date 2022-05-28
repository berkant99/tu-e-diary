<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
$id = $_SESSION['id'];
$query = "SELECT gr.student_id, gr.teacher_id, DATE(gr.exam_date) as date, gr.grade, gr.semester, d.discipline, CONCAT(t.title, ' ', tchr.name, ' ', tchr.lastname) as teacher FROM grades gr
JOIN disciplines d ON gr.discipline_id = d.discipline_id
JOIN teachers tchr ON gr.teacher_id = tchr.teacher_id
JOIN titles t ON tchr.title_id = t.title_id
WHERE gr.student_id = '{$id}'";
$result = $conn->query($query);

$query = "SELECT AVG(grade) as average FROM grades WHERE student_id = '{$id}' AND grade > 2";
$avrg = $conn->query($query)->fetch_assoc()['average'];

$query = "SELECT COUNT(grade) as success FROM grades WHERE student_id = '{$id}' AND (grade > 2 OR grade = 1)";
$success = $conn->query($query)->fetch_assoc()['success'];

$query = "SELECT COUNT(grade) as fail FROM grades WHERE student_id = '{$id}' AND (grade = 2 OR grade = 0)";
$fail = $conn->query($query)->fetch_assoc()['fail'];

$query = "SELECT COUNT(grade) as authentication FROM grades WHERE student_id = '{$id}' AND grade = -1";
$authentication = $conn->query($query)->fetch_assoc()['authentication'];

$query = "SELECT AVG(grade) as average, student_id, dense_rank() OVER (ORDER BY average desc) AS rank FROM grades WHERE grade > 2 GROUP BY student_id";
$rankResult = $conn->query($query);
while ($row = $rankResult->fetch_assoc()) {
    if ($row['student_id'] == $id) {
        $universityRank = $row['rank'];
    }
}

$query = "SELECT AVG(g.grade) as average, g.student_id, st.form_of_education,
dense_rank() OVER (PARTITION BY SUBSTR(g.student_id, 1, 4), st.form_of_education ORDER BY average desc) AS rank FROM grades g
JOIN students st ON g.student_id = st.facultyNumber WHERE g.grade > 2 GROUP BY g.student_id";
$rankResult = $conn->query($query);
while ($row = $rankResult->fetch_assoc()) {
    if ($row['student_id'] == $id) {
        $groupRank = $row['rank'];
    }
}
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
            $gradeResult = 'Слаб 2';
            break;
        case 3:
            $gradeResult = 'Среден 3';
            break;
        case 4:
            $gradeResult = 'Добър 4';
            break;
        case 5:
            $gradeResult = 'Мн. добър 5';
            break;
        case 6:
            $gradeResult = 'Отличен 6';
            break;
    endswitch;
    return $gradeResult;
}

function getStatus($grade)
{
    $status = '';
    switch ($grade):
        case -1:
        case 0:
        case 2:
            $status = 'poor';
            break;
        case 1:
        case 6:
            $status = 'excellent';
            break;
        case 3:
            $status = 'fair';
            break;
        case 4:
            $status = 'good';
            break;
        case 5:
            $status = 'very-good';
            break;
    endswitch;
    return $status;
}
