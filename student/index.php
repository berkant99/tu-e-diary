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
<div class="main">
    <?php if (isset($_SESSION['verification-scs-msg'])) : ?>
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <div class="icon">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            <div class="text"><?php echo $_SESSION['verification-scs-msg'] ?></div>
            <div class="close-icon"><i class="fa fa-xmark" id="hide-alert" aria-hidden="true"></i></div>
        </div>
    <?php
        unset($_SESSION['verification-scs-msg']);
    endif;
    ?>
    <div class="box cardBox">
        <div class="card c-average">
            <div class="hr-group">
                <div id="average" class="numbers">
                    5.58
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
            </div>
            <div class="cardName">Среден успех</div>
        </div>
        <div class="card c-success">
            <div class="hr-group">
                <div id="s-exams" class="numbers">
                    27
                </div>
                <div class="iconBox">
                    <i class="fa fa-smile-o" aria-hidden="true"></i>
                </div>
            </div>
            <div class="cardName">Успешно положени изпити</div>
        </div>
        <div class="card c-frown">
            <div class="hr-group">
                <div id="f-exams" class="numbers">
                    2
                </div>
                <div class="iconBox">
                    <i class="fa fa-frown-o" aria-hidden="true"></i>
                </div>
            </div>
            <div class="cardName">Невзети изпити</div>
        </div>
        <div class="card c-meh">
            <div class="hr-group">
                <div id="u-disciplines" class="numbers">
                    6
                </div>
                <div class="iconBox">
                    <i class="fa fa-meh-o" aria-hidden="true"></i>
                </div>
            </div>
            <div class="cardName">Незаверени дисциплини</div>
        </div>
    </div>
    <div class="box chartBox">
        <div class="card">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div class="ranking-title">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
                <label for="ranking">Класация</label>
            </div>
            <div class="rankingBox">
                <div class="ranking">
                    <div class="hr-group">
                        <div class="number" id="stream">15</div>
                        <i class="fa-solid fa-users-line"></i>
                    </div>
                    <div class="text">Място в потока</div>
                </div>
                <div class="ranking">
                    <div class="hr-group">
                        <div class="number" id="university">256</div>
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div class="text">Място в университета</div>
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/libs/chart.js"></script>
<script src="../assets/js/libs/countUp.js"></script>
<script src="../student/assets/js/index.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<script src="../student/jsControllers/lastActivity.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>