<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit();
} else if ($_SESSION['firstLogin'] == FALSE) {
    header('location: first-signin');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/teacher/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/teacher/layout/sideMenu.php';
?>
<div class="main card-cntr">
    <div class="box">
        <div class="card">
            <div class="hr-group" id="group">
                <div class="user-box">
                    <div class="search">
                        <span class="text">Потърсете студент...</span>
                        <input type="text" placeholder="Въведете име, фак. ном. или катедра...">
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
                    <!-- Chat box will be displayed here -->
                    <div class="vr-group" id="start-conversation">
                        <i class="fa-solid fa-comments"></i>
                        <div class="text">
                            Започнете нов разговор...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../teacher/jsControllers/lastActivity.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<script src="assets/js/chat.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/teacher/layout/footer.php'; ?>