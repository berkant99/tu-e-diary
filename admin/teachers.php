<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/sideMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/teacherControllers/getDropdownValues.php';

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
                            <span class="text">Потърсете преподавател...</span>
                            <input type="text" placeholder="Въведете име, катедра или имейл...">
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
                        <!--Teacher info will be displayed here -->
                        <div class="vr-group" id="find-teacher">
                            <i class="fa-solid fa-person-chalkboard"></i>
                            <div class="text">
                                Потърсете преподавател...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="add-box" style="display: none;">
                <div class="object-center" style="height: auto;">
                    <div class="container">
                        <div class="wrapper" style="box-shadow: none; background: none;">
                            <div class="form-title">Добавяне на преподавател</div>
                            <div class="alert alert-success" style="display: none;">
                                <div class="icon">
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    Успешно добавяне на преподавател!
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
                            <form id="add-teacher-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                                <div class="hr-group" style="justify-content: center;">
                                    <div class="right-box" style="min-width: 300px; margin-right: 20px;">
                                        <div class="field">
                                            <input type="text" name="tchr-name" id="tchr-name" maxlength="15">
                                            <label>Име</label>
                                            <span id="nameError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="tchr-middlename" id="tchr-middlename" maxlength="15">
                                            <label>Презиме</label>
                                            <span id="mnameError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="tchr-lastname" id="tchr-lastname" maxlength="50">
                                            <label>Фамилия</label>
                                            <span id="lnameError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="tchr-email" id="tchr-email" maxlength="50">
                                            <label>Имейл</label>
                                            <span id="emailError"></span>
                                        </div>
                                    </div>
                                    <div class="left-box" style="min-width: 300px;">
                                        <div class="field">
                                            <input type="text" name="tchr-egn" id="tchr-egn" maxlength="10">
                                            <label>ЕГН</label>
                                            <span id="egnError"></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="tchr-title" id="tchr-title" style="cursor: pointer; padding-right: 30px;" readonly>
                                            <input type="hidden" name="tchr-title-id" id="tchr-title-id">
                                            <i class="fa fa-chevron-left"></i>
                                            <label>Научна степен</label>
                                            <span></span>
                                            <div class="select-dropdown" id="select-title-dropdown">
                                                <ul id="select-title">
                                                    <?php
                                                    while ($row = $titles->fetch_assoc()) {
                                                        echo "<li id='" . $row['title_id'] . "'>" . $row["title"] . "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="tchr-department" id="tchr-department" style="cursor: pointer; padding-right: 30px;">
                                            <input type="hidden" name="tchr-department-id" id="tchr-department-id">
                                            <i class="fa fa-chevron-left"></i>
                                            <label>Катедра</label>
                                            <span></span>
                                            <div class="select-dropdown" id="select-department-dropdown">
                                                <ul id="select-department">
                                                    <li class="result" style="color: #99190b; display: none; cursor: not-allowed;" id="result">Няма съвпадения!</li>
                                                    <?php
                                                    while ($row = $departments->fetch_assoc()) {
                                                        echo "<li id='" . $row['department_id'] . "' value='" . $row["dep"] . "'>" . $row["department"] . "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="tchr-cabinet" id="tchr-cabinet" maxlength="6">
                                            <label>Кабинет</label>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <button type="submit" name="add-teacher-btn">Добави</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edit-box" style="display: none;"></div>
        </div>
    </div>
</div>
<script src="../admin/assets/js/teachers.js?v=<?php echo time(); ?>" type="module"></script>
<script src="../admin/assets/js/js.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/footer.php'; ?>