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
if (!egn_valid($_POST['st-egn'])) {
    $errorText = "Въведеното ЕГН е навалидно!";
} else {
    $query = "SELECT * FROM students WHERE facultyNumber = '{$_POST['st-fnum']}'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        $query = "INSERT INTO `students`(`facultyNumber`, `firstname`, `middlename`, `lastname`, `specialty`, `form_of_education`, `st_group`, `course`)
VALUES ('{$_POST['st-fnum']}','{$_POST['st-name']}','{$_POST['st-middlename']}','{$_POST['st-lastname']}',{$_POST['st-specialty-id']},{$_POST['st-eform-id']},'{$_POST['st-group']}','{$_POST['st-course']}')";
        $result = $conn->query($query);
        if ($result) {
            $query = "INSERT INTO `st_login`(`facultyNumber`, `password`) VALUES ('{$_POST['st-fnum']}','" . password_hash($_POST['st-egn'], PASSWORD_DEFAULT) . "')";
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
        $errorText = "Съществува студент с този факултетен номер!";
    }
}
if ($errorText != '') {
    echo $errorText;
}
