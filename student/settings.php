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
    <div class="box settings">
        <div class="card">
            <div class="hr-group" id="btn-group">
                <button id="settings-btn" class="settings-title">
                    Настройки на профила
                </button>
                <button id="info-btn" class="settings-title">
                    Лична информация
                </button>
            </div>
            <div id="settings-id">
                <!-- Settings will displayed here -->
                <div class="center-group" style="height: auto;">
                    <div class="container">
                        <div class="wrapper" style="box-shadow: none; background: none;">
                            <div class="alert alert-error" style="display: none; margin-top: 10px;">
                                <div class="icon">
                                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                                </div>
                                <div class="text"></div>
                                <div></div>
                            </div>
                            <form id="img-form" class="profile-pic object-center" style="margin-bottom: 15px;">
                                <label class="img-label" for="file">
                                    <div class="hr-group">
                                        <i class="fa-solid fa-camera-retro" style="margin-right: 10px;"></i>
                                        <span>Промяна</span>
                                    </div>
                                </label>
                                <input id="file" name="image" type="file" accept="image/x-png,image/jpeg,image/jpg">
                                <img src="/e-diary/profile-pictures/<?php echo $_SESSION['img'] ?>" id="output-img">
                            </form>
                            <?php if ($_SESSION["img"] != "default.jpg") : ?>
                                <div class="object-center" style="margin: 15px;">
                                    <div>
                                        <button id="delete-img-btn" type="button"><div class="hr-group"><i class="fa-solid fa-xmark" style="margin-right: 10px;"></i>Премахване на снимката</div></button>
                                    </div>
                                </div>
                            <?php endif ?>
                            <form id="student-settings-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="margin: 0;">
                                <div class="field focused">
                                    <input type="text" disabled id="current-email" placeholder="<?php echo $_SESSION['email'] ?>">
                                    <label>Текущ имейл</label>
                                    <span></span>
                                </div>
                                <div class="field">
                                    <input type="text" name="settings-email" id="settings-email">
                                    <label>Нов имейл</label>
                                    <span id="settingsEmailError"></span>
                                </div>
                                <div class="field">
                                    <button type="submit" name="save-settings">Промяна на имейл</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="info-id">
                <!-- Personal information will displayed here -->
            </div>
        </div>
    </div>
</div>
<script src="../student/assets/js/settings.js?v=<?php echo time(); ?>" type="module"></script>
<script src="../student/jsControllers/lastActivity.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<!-- <script src="assets/js/chat.js?v=<?php echo time(); ?>" type="text/javascript"></script> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>