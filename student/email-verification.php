<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/serverControllers/emailVerficationCtrl.php';
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
} else if (!isset($_SESSION['email'])) {
    header('location: first-signin.php');
    exit();
} else if (isset($_SESSION['verified'])) {
    header('location: index.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php'; ?>
<nav>
    <div class="logo">
        <img src="/e-diary/assets/images/logo.png">
    </div>
    <div class="logout">
        <a href="login.php?logout_id=<?php echo $_SESSION['id']; ?>">
            <div><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
        </a>
    </div>
</nav>
<div class="center-group">
    <div class="container">
        <div class="wrapper">
            <div class="form-title">Потвърждаване на имейл</div>
            <hr>
            <div class="alert alert-success" style="display: none;">
                <div class="icon">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                </div>
                <div class="text">
                    Изпратен е шестцифрен код за потвърждение на адрес <?php echo $_SESSION['email'] ?>.<br>
                    Кодът е валиден в продължение на 30 минути!
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
            <form id="email-verification-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="field">
                    <input type="text" name="verification-code" id="verification-code" maxlength="6">
                    <label>Код за потвърждение</label>
                    <span></span>
                </div>
                <div class="field">
                    <button type="submit" name="email-verification-btn">Потвърди</button>
                </div>
                <div class="link-text"><a href="email-verification.php?send-code-again=<?php echo $_SESSION['email'] ?>">Изпращане на кода отново.</a></div>
            </form>
        </div>
    </div>
</div>
<script src="jsControllers/emailVerification.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>