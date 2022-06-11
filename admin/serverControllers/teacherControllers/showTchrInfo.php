<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/teacherControllers/getDropdownValues.php';
$output = '';
$depList = '';
$titleList = '';
if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $query = "SELECT tchr.teacher_id, tchr.email, tp.img, tchr.cabinet, CONCAT(t.title, ' ', tchr.name, ' ', tchr.middlename, ' ', tchr.lastname) as teacher,
    d.department FROM teachers tchr
    JOIN departments d ON tchr.department_id = d.department_id
    JOIN titles t ON tchr.title_id = t.title_id
    JOIN t_profile tp ON tchr.teacher_id = tp.teacher_id
    WHERE tchr.teacher_id = {$id}";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output .= '
        <fieldset id="tchr-info">
            <div class="hr-group">
                <div class="tchr-name">' . $row['teacher'] . '</div>
                <div class="back-icon"><i class="fa-solid fa-xmark"></i></div>
            </div>
            <dl class="dl-horizontal">
                <div class="object-center">
                    <img src="/e-diary/profile-pictures/' . $row['img'] . '" id="output-img" style="width: 180px; height: 180px;">
                </div>
                <dt>Катедра:</dt>
                <dd>' . $row['department'] . '</dd>
                <dt><i class="fa-solid fa-envelope"></i> </dt>
                <dd>' . $row['email'] . '</dd>
                <dt><i class="fa-solid fa-location-dot"></i> </dt>
                <dd>' . $row['cabinet'] . '</dd>
                <div class="object-center">
                <button id="send-tchr-msg" type="button">
                    <div class="hr-group" style="justify-content: center;">
                    <i class="fa-solid fa-user-pen" style="margin-right: 10px;"></i>Редактиране</div>
                </button>
                </div>
                <div class="object-center">
                <button id="delete-tchr-info" type="button">
                    <div class="hr-group" style="justify-content: center;">
                    <i class="fa-solid fa-trash-can" style="margin-right: 10px;"></i>Изтриване</div>
                </button>
                </div>
            </dl>
        </fieldset>';
    }
    echo $output;
}

if (isset($_POST['tchrId'])) {
    $id = $_POST['tchrId'];
    while ($row1 = $departments->fetch_assoc()) {
        $depList .= "<li id='" . $row1['department_id'] . "' value='" . $row1["dep"] . "'>" . $row1["department"] . "</li>";
    }
    while ($row2 = $titles->fetch_assoc()) {
        $titleList .= "<li id='" . $row2['title_id'] . "'>" . $row2["title"] . "</li>";
    }
    $query = "SELECT tchr.teacher_id, tchr.email, tchr.cabinet, tchr.department_id, tchr.title_id, t.title, tchr.name, tchr.middlename, tchr.lastname, SUBSTRING_INDEX(SUBSTRING_INDEX(d.department, '(', -1), ')', 1) as dep FROM teachers tchr
    JOIN departments d ON tchr.department_id = d.department_id
    JOIN titles t ON tchr.title_id = t.title_id
    WHERE tchr.teacher_id = {$id}";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output = '<div class="object-center" style="height: auto;">
        <div class="container">
            <div class="wrapper" style="box-shadow: none; background: none;">
                <div class="form-title">Редактиране на данни на преподавател</div>
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
                <form id="edit-teacher-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                    <div class="hr-group" style="justify-content: center;">
                        <div class="right-box" style="min-width: 300px; margin-right: 20px;">
                            <div class="field focused">
                                <input type="text" name="tchr-name" id="tchr-name" maxlength="15" value="' . $row['name'] . '" readonly>
                                <label>Име</label>
                                <span id="nameError"></span>
                            </div>
                            <div class="field focused">
                                <input type="text" name="tchr-middlename" id="tchr-middlename" maxlength="15" value="' . $row['middlename'] . '" readonly>
                                <label>Презиме</label>
                                <span id="mnameError"></span>
                            </div>
                            <div class="field focused">
                                <input type="text" name="tchr-lastname" id="e-tchr-lastname" maxlength="50" value="' . $row['lastname'] . '">
                                <label>Фамилия</label>
                                <span id="e-lnameError"></span>
                            </div>
                            <div class="field focused">
                                <input type="text" name="tchr-email" id="tchr-email" maxlength="50" value="' . $row['email'] . '" readonly>
                                <label>Имейл</label>
                                <span id="emailError"></span>
                            </div>
                        </div>
                        <div class="left-box" style="min-width: 300px;">
                            <div class="field focused">
                                <input type="text" name="tchr-egn" id="tchr-egn" maxlength="10" value="' . $row['teacher_id'] . '" readonly>
                                <label>ЕГН</label>
                                <span id="egnError"></span>
                            </div>
                            <div class="field focused">
                                <input type="text" name="tchr-title" id="e-tchr-title" style="cursor: pointer; padding-right: 30px;" value="' . $row['title'] . '" readonly>
                                <input type="hidden" name="tchr-title-id" id="e-tchr-title-id" value="' . $row['title_id'] . '">
                                <i class="fa fa-chevron-left"></i>
                                <label>Научна степен</label>
                                <span></span>
                                <div class="select-dropdown" id="e-select-title-dropdown">
                                    <ul id="e-select-title">
                                    ' . $titleList . '
                                    </ul>
                                </div>
                            </div>
                            <div class="field focused">
                                <input type="text" name="tchr-department" id="e-tchr-department" style="cursor: pointer; padding-right: 30px;" value="' . $row['dep'] . '" readonly>
                                <input type="hidden" name="tchr-department-id" id="e-tchr-department-id" value="' . $row['department_id'] . '">
                                <i class="fa fa-chevron-left"></i>
                                <label>Катедра</label>
                                <span></span>
                                <div class="select-dropdown" id="e-select-department-dropdown">
                                    <ul id="e-select-department">
                                    ' . $depList . '
                                    </ul>
                                </div>
                            </div>
                            <div class="field focused">
                                <input type="text" name="tchr-cabinet" id="e-tchr-cabinet" value="' . $row['cabinet'] . '" maxlength="6">
                                <label>Кабинет</label>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <button type="submit" name="edit-teacher-btn">Запазване на промните</button>
                    </div>
                </form>
            </div>
        </div>
    </div>';
    }
    echo $output;
}
