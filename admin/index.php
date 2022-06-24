<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/sideMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/getStatistics.php';
?>
<div class="main">
    <div class="box cardBox">
        <div class="card c-average">
            <div class="hr-group">
                <div id="average" class="numbers">
                    <?php echo number_format($avrg, 2) ?>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
            </div>
            <div class="cardName">Среден успех в университета</div>
        </div>
        <div class="card c-average">
            <div class="hr-group">
                <div id="students" class="numbers">
                    <?php echo $students ?>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
            <div class="cardName">Общ брой студенти</div>
        </div>
        <div class="card c-average">
            <div class="hr-group">
                <div id="teachers" class="numbers">
                    <?php echo $teachers ?>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
            </div>
            <div class="cardName">Общ брой преподаватели</div>
        </div>
        <div class="card c-average">
            <div class="hr-group">
                <div id="specialties" class="numbers">
                    <?php echo $specialties ?>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-book"></i>
                </div>
            </div>
            <div class="cardName">Специалности</div>
        </div>
    </div>
    <div class="box chartBox" style="grid-template-columns: repeat(1, 1fr);">
        <div class="card">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>
<script src="../assets/js/libs/chart.js"></script>
<script src="../assets/js/libs/countUp.js"></script>
<script src="../admin/assets/js/index.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/footer.php'; ?>