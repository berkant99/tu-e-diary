<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/sideMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/studentsControllers/getDropdownValues.php';
?>
<div class="main card-cntr admin">
    <div class="box" style="min-width: 750px;">
        <div class="card">
            <div class="hr-group" id="btn-group">
                <button id="search-btn" class="settings-title">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Търсене
                </button>
                <button id="add-btn" class="settings-title">
                    <i class="fa-solid fa-plus"></i>
                    Добавяне
                </button>
                <button id="edit-btn" class="settings-title">
                    <i class="fa-solid fa-user-pen"></i>
                    Редактиране
                </button>
            </div>
            <div id="search-box">
                <div class="hr-group" id="group">
                    <div class="user-box">
                        <div class="search">
                            <span class="text">Потърсете студент...</span>
                            <input type="text" placeholder="Въведете име, фак. номер или катедра...">
                            <button><i class="fa-solid fa-search"></i></button>
                        </div>
                        <div class="alert alert-error" id="usr-not-found-err">
                            <div class="icon">
                                <i class="fa fa-frown-o" style="border: none; font-size: 28px;" aria-hidden="true"></i>
                            </div>
                            <div class="text" style="text-align: center;">
                                Няма резултати от търсенето...
                            </div>
                        </div>
                        <div class="vr-group" style="height: calc(100% - 60px);">
                            <div class="loader"></div>
                        </div>
                        <div class="users-list" id="users-list">
                            <!-- Users will be listed here -->
                        </div>
                    </div>
                    <div class="msg-box">
                        <!-- Student info will be displayed here -->
                        <div class="vr-group" id="find-student">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <div class="text">
                                Потърсете студент...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="add-box" style="display: none;">
                <div class="object-center" style="height: auto;">
                    <div class="container">
                        <div class="wrapper" style="box-shadow: none; background: none;">
                            <div class="form-title">Добавяне на студент</div>
                            <div class="alert alert-success" style="display: none;">
                                <div class="icon">
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    Успешно добавяне на студент!
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
                            <form id="add-student-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                                <div class="hr-group" style="justify-content: center;">
                                    <div class="right-box" style="min-width: 300px; margin-right: 20px;">
                                        <div class="field">
                                            <input type="text" name="st-name" id="st-name" maxlength="15">
                                            <label>Име</label>
                                            <span id="nameError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="st-middlename" id="st-middlename" maxlength="15">
                                            <label>Презиме</label>
                                            <span id="mnameError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="st-lastname" id="st-lastname" maxlength="50">
                                            <label>Фамилия</label>
                                            <span id="lnameError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="st-fnum" id="st-fnum" maxlength="10">
                                            <label>Факултетен номер</label>
                                            <span id="fNumError"></span>
                                        </div>
                                    </div>
                                    <div class="left-box" style="min-width: 300px;">
                                        <div class="field">
                                            <input type="text" name="st-specialty" id="st-specialty" style="cursor: pointer; padding-right: 30px;">
                                            <input type="hidden" name="st-specialty-id" id="st-specialty-id">
                                            <i class="fa fa-chevron-left"></i>
                                            <label>Специалност</label>
                                            <span></span>
                                            <div class="select-dropdown" id="select-specialty-dropdown">
                                                <ul id="select-specialty">
                                                    <li class="result" style="color: #99190b; display: none; cursor: not-allowed;" value="" id="result">Няма съвпадения!</li>
                                                    <?php
                                                    while ($row = $specialties->fetch_assoc()) {
                                                        echo "<li id='" . $row['specialty_id'] . "' value='" . $row["spec"] . "'>" . $row["specialty"] . "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="st-eform" id="st-eform" style="cursor: pointer; padding-right: 30px;" readonly>
                                            <input type="hidden" name="st-eform-id" id="st-eform-id">
                                            <i class="fa fa-chevron-left"></i>
                                            <label>Форма на обучение</label>
                                            <span></span>
                                            <div class="select-dropdown" id="select-eform-dropdown">
                                                <ul id="select-eform">
                                                    <?php
                                                    while ($row = $formOfEd->fetch_assoc()) {
                                                        echo "<li id='" . $row['form_id'] . "'>" . $row["form_ed"] . "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="st-group" id="st-group" style="cursor: pointer; padding-right: 30px;" readonly>
                                            <i class="fa fa-chevron-left"></i>
                                            <label>Група</label>
                                            <span></span>
                                            <div class="select-dropdown" id="select-group-dropdown">
                                                <ul id="select-group">
                                                    <?php
                                                    for ($i = 1; $i <= 10; $i += 1) {
                                                        echo "<li id='" . $i . "'>" . $i . "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="st-course" id="st-course" style="cursor: pointer; padding-right: 30px;" readonly>
                                            <i class="fa fa-chevron-left"></i>
                                            <label>Курс</label>
                                            <span></span>
                                            <div class="select-dropdown" id="select-course-dropdown">
                                                <ul id="select-course">
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i += 1) {
                                                        echo "<li id='" . $i . "'>" . $i . "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <input type="text" name="st-egn" id="st-egn" maxlength="10">
                                    <label>ЕГН</label>
                                    <span id="egnError"></span>
                                </div>
                                <div class="field">
                                    <button type="submit" name="add-student-btn">Добави</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edit-box" style="display: none;">
            </div>
        </div>
    </div>
</div>
<script src="../admin/assets/js/students.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/footer.php'; ?>