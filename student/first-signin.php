<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
} else if ($_SESSION['firstLogin'] == TRUE) {
    header('location: email-verification.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php'; ?>
<nav style="position: relative;">
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
        <div class="form-title">Промяна на парола</div>
        <hr>
        <?php if (isset($_SESSION['name'])) : ?>
            <div class="alert alert-warning">
                <div class="icon">
                    <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
                </div>
                <div class="text">
                    Здравейте, <?php echo $_SESSION['name'] ?><br>
                    За да продължите е необходимо да промените паролата си и да въведете имейл адрес,
                    който ще се използва за възстановяване на забравена парола!
                </div>
            </div>
        <?php endif; ?>
        <div class="alert alert-error" style="display: none;">
            <div class="icon">
                <i class="fa-solid fa-exclamation" aria-hidden="true"></i>
            </div>
            <div class="text"></div>
            <div></div>
        </div>
        <form id="first-signin-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="field">
                <input type="password" name="newPass" id="newPass" maxlength="16">
                <label>Парола</label>
                <i class="fa fa-eye" id="show-hide-pass-new" aria-hidden="true"></i>
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
                <input type="password" name="repeatPass" id="repeatPass" maxlength="16">
                <label>Повтори паролата</label>
                <span id="repeatPassError"></span>
            </div>
            <div class="field">
                <input type="text" name="email" id="email">
                <label>Имейл</label>
                <span id="emailError"></span>
            </div>
            <div class="field">
                <button type="submit" name="first-signin-btn">Напред</button>
            </div>
        </form>
    </div>
</div>
</div>
<script src="jsControllers/first-login.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>