<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
if (isset($_SESSION['id'])) {
    header('location: index.php');
    exit();
}
if (isset($_SESSION['email-reset'])) {
    unset($_SESSION['email-reset']);
}
?>
<nav>
    <a href="/e-diary/student/login.php">
        <div class="logo">
            <img src="/e-diary/assets/images/logo.png">
        </div>
    </a>
</nav>
<div class="center-group">
    <div class="container">
        <div class="wrapper">
            <div class="form-title">Забравена парола</div>
            <hr>
            <div class="alert alert-warning">
                <div class="icon">
                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                </div>
                <div class="text">
                    Ще изпратим ключ за възстановяване на паролата в посочения от вас имейл адрес.
                </div>
            </div>
            <div class="alert alert-error" style="display: none;">
                <div class="icon">
                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                </div>
                <div class="text"></div>
                <div></div>
            </div>
            <form id="forgotten-pass-form" action="#" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <input type="text" name="email" id="email" autocomplete="off">
                    <label>Имейл</label>
                    <span id="emailError"></span>
                </div>
                <div class="field">
                    <button type="submit" name="forgotten-pass-btn">Напред</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="jsControllers/forgottenPass.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>