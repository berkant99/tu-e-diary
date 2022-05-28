<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
} else if ($_SESSION['firstLogin'] == FALSE) {
    header('location: first-signin.php');
    exit();
} else if (!isset($_SESSION['verified'])) {
    header('location: email-verification.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/sideMenu.php';
?>
<div class="main card-cntr">
    <div class="box">
        <div class="card">
            <div class="hr-group" id="group">
                <div class="user-box">
                    <div class="search">
                        <span class="text">Потърсете преподавател...</span>
                        <input type="text" placeholder="Въведете име, имейл или катедра...">
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
                    <!-- Teacher info will be displayed here -->
                    <div class="vr-group" id="find-teacher">
                        <i class="fa-solid fa-person-chalkboard"></i>
                        <div class="text">
                            Потърсете преподавател...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../student/jsControllers/lastActivity.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<script src="assets/js/teachers.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>