<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/errors.php';
function egn_valid($egn)
{
    $EGN_WEIGHTS = array(2, 4, 8, 5, 10, 9, 7, 3, 6);
    if (strlen($egn) != 10)
        return false;
    $year = substr($egn, 0, 2);
    $mon  = substr($egn, 2, 2);
    $day  = substr($egn, 4, 2);
    if ($mon > 40) {
        if (!checkdate($mon - 40, $day, $year + 2000)) return false;
    } else
    if ($mon > 20) {
        if (!checkdate($mon - 20, $day, $year + 1800)) return false;
    } else {
        if (!checkdate($mon, $day, $year + 1900)) return false;
    }
    $checksum = substr($egn, 9, 1);
    $egnsum = 0;
    for ($i = 0; $i < 9; $i++)
        $egnsum += substr($egn, $i, 1) * $EGN_WEIGHTS[$i];
    $valid_checksum = $egnsum % 11;
    if ($valid_checksum == 10)
        $valid_checksum = 0;
    if ($checksum == $valid_checksum)
        return true;
}
$errorText = '';
if (!egn_valid($_POST['tchr-egn'])) {
    $errorText = "Въведеното ЕГН е навалидно!";
} else {
    $query = "SELECT * FROM teachers WHERE teacher_id = '{$_POST['tchr-egn']}' OR email = '{$_POST['tchr-email']}'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        $query = "INSERT INTO `teachers`(`teacher_id`, `email`, `name`, `middlename`, `lastname`, `department_id`, `title_id`, `cabinet`)
VALUES ('{$_POST['tchr-egn']}','{$_POST['tchr-email']}','{$_POST['tchr-name']}','{$_POST['tchr-middlename']}','{$_POST['tchr-lastname']}',{$_POST['tchr-department-id']},{$_POST['tchr-title-id']},'{$_POST['tchr-cabinet']}')";
        $result = $conn->query($query);
        if ($result) {
            $query = "INSERT INTO `t_profile`(`teacher_id`, `password`) VALUES ('{$_POST['tchr-egn']}','" . password_hash($_POST['tchr-egn'], PASSWORD_DEFAULT) . "')";
            $result = $conn->query($query);
            if ($result) {
                echo "success";
            } else {
                $errorText = $errors['error'];
            }
        } else {
            $errorText = $errors['error'];
        }
    } else {
        $errorText = "Съществува преподавател с това ЕГН и/или с този имейл адрес!";
    }
}
if ($errorText != '') {
    echo $errorText;
}
