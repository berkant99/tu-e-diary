<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/serverControllers/logoutController.php';
session_start();
if (isset($_SESSION['id'])) {
    if ($_SESSION['firstLogin'] == FALSE) {
        header('location: first-signin.php');
    } else if (!isset($_SESSION['verified'])) {
        header('location: email-verification.php');
    } else {
        header('location: index.php');
    }
    exit();
}
if (isset($_SESSION['email-reset'])) {
    unset($_SESSION['email-reset']);
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
?>
<div class="center-group">
    <div class="container">
        <div class="wrapper">
            <img src="/e-diary/assets/images/logo.png">
            <hr>
            <div class="alert alert-info">
                <div class="icon">
                    <i class="fa-solid fa-info"></i>
                </div>
                <div class="text">При първо влизане паролата е Вашето ЕГН!</div>
                <div class="close-icon"><i class="fa-solid fa-xmark" id="hide-alert" aria-hidden="true"></i></div>
            </div>
            <div class="alert alert-error" style="display: none;">
                <div class="icon">
                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                </div>
                <div class="text"></div>
                <div></div>
            </div>
            <?php if (isset($_SESSION['password-change-msg'])) : ?>
                <div class="alert alert-success">
                    <div class="icon">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <div class="text"><?php echo $_SESSION['password-change-msg'] ?></div>
                    <div></div>
                </div>
            <?php unset($_SESSION['password-change-msg']);
            endif; ?>
            <form id="student-login-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="field">
                    <input type="text" name="facultyNumber" id="facultyNumber" maxlength="8">
                    <label>Факултетен номер</label>
                    <span></span>
                </div>
                <div class="field">
                    <input type="password" name="password" id="password" maxlength="16">
                    <label>Парола</label>
                    <span></span>
                </div>
                <div class="forgotten-pass"><a href="/e-diary/student/forgotten-pass.php">Забравена парола?</a></div>
                <div class="field">
                    <button type="submit" name="student-login-btn">Вход</button>
                </div>
                <div class="link-text"><a href="/e-diary/login-teacher.php">Вход за преподаватели/служители.</a></div>
            </form>
        </div>
    </div>
</div>
<script src="jsControllers/login.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>