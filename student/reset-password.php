<?php
session_start();
if (isset($_SESSION['id'])) {
    header('location: index.php');
    exit();
}
if (!isset($_SESSION['email-reset'])) {
    header('location: forgotten-pass.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php'; ?>
<nav>
    <a href="/e-diary/student/login.php">
        <div class="logo">
            <img src="/e-diary/assets/images/logo.png">
        </div>
    </a>
</nav>
<div class="container" style="margin-top: 170px;">
    <div class="wrapper">
        <div class="form-title">Промяна на парола</div>
        <hr>
        <div class="alert alert-success" style="display: none;">
            <div class="icon">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            <div class="text">Изпратихме ключ за подновяване на паролата до <?php echo $_SESSION['email-reset'] ?><br />
                Ключът е валиден в следващите 30 минути.</div>
            <div></div>
        </div>
        <div class="alert alert-error" style="display: none;">
            <div class="icon">
                <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
            </div>
            <div class="text"></div>
            <div></div>
        </div>
        <form id="reset-password-form" action="#" method="POST" enctype="multipart/form-data">
            <div class="field">
                <input type="password" name="newPass-reset" id="newPass-reset" maxlength="16" autocomplete="off">
                <label>Парола</label>
                <i class="fa fa-eye" id="show-hide-pass-reset" aria-hidden="true"></i>
                <span id="newPassError"></span>
            </div>
            <ul id='passList'>
                <li><i class="fa fa-check"></i>Главна буква</li>
                <li><i class="fa fa-check"></i>Малка буква</li>
                <li><i class="fa fa-check"></i>Число</li>
                <li><i class="fa fa-check"></i>Специален знак ! @ # $ % & * ^</li>
                <li><i class="fa fa-check"></i>Минимум 8 символа</li>
            </ul>
            <div class="field">
                <input type="password" name="repeatPass-reset" id="repeatPass-reset" maxlength="16" autocomplete="off">
                <label>Повтори паролата</label>
                <span id="repeatPassError"></span>
            </div>
            <div class="field">
                <input type="text" name="key" id="key" autocomplete="off">
                <label>Ключ за промяна</label>
                <span></span>
            </div>
            <div class="field">
                <button type="submit" name="reset-password-btn">Промени паролата</button>
            </div>
        </form>
    </div>
</div>
<script src="jsControllers/resetPass.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>