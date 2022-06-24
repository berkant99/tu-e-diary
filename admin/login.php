<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/logoutController.php';
session_start();
if (isset($_SESSION['id'])) {
    header('location: home');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
?>
<div class="center-group">
    <div class="container">
        <div class="wrapper">
            <img src="/e-diary/assets/images/logo.png">
            <hr>
            <div class="alert alert-error" style="display: none;">
                <div class="icon">
                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                </div>
                <div class="text"></div>
                <div></div>
            </div>
            <form id="admin-login-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="field">
                    <input type="text" name="username" id="username" maxlength="16">
                    <label>Потребителско име</label>
                    <span></span>
                </div>
                <div class="field">
                    <input type="password" name="password" id="password" maxlength="16">
                    <label>Парола</label>
                    <span></span>
                </div>
                <div class="field">
                    <button type="submit" name="admin-login-btn">Вход</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="jsControllers/login.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/footer.php'; ?>