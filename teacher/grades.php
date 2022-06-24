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
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/teacher/serverControllers/gradeControllers/getDropdownValues.php';
?>
<div class="main card-cntr" style="min-width: 500px;">
    <div class="box settings">
        <div class="card">
            <div class="hr-group" id="btn-group">
                <button id="add-group-btn" class="settings-title">
                    Групово въвеждане
                </button>
                <button id="add-individual-btn" class="settings-title">
                    Индивидуално въвеждане
                </button>
            </div>
            <div id="add-group-id">
                <div id="form-add-groupGrade">
                    <div class="object-center" style="height: auto;">
                        <div class="container" style="max-width: none; width: 550px;">
                            <div class="wrapper" style="box-shadow: none; background: none;">
                                <div class="form-title">Въвеждане на оценка</div>
                                <form id="add-groupGrade-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                                    <div class="field">
                                        <input type="text" name="gr-discipline" id="gr-discipline" style="cursor: pointer; padding-right: 30px;">
                                        <input type="hidden" name="gr-discipline-id" id="gr-discipline-id">
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Дисциплина</label>
                                        <span></span>
                                        <div class="select-dropdown" id="gr-select-discipline-dropdown">
                                            <ul id="gr-select-discipline" style="max-height: 115px;">
                                                <li class="result" style="color: #99190b; display: none; cursor: not-allowed;" id="result">Няма съвпадения!</li>
                                                <?php
                                                while ($row = $grDisciplines->fetch_assoc()) {
                                                    echo "<li id='" . $row['discipline_id'] . "'>" . $row["discipline"] . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="st-specialty" id="st-specialty" style="cursor: pointer; padding-right: 30px;">
                                        <input type="hidden" name="st-specialty-id" id="st-specialty-id">
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Специалност</label>
                                        <span></span>
                                        <div class="select-dropdown" id="select-specialty-dropdown">
                                            <ul id="select-specialty">
                                                <li class="result" style="color: #99190b; display: none; cursor: not-allowed;" value="" id="result">Няма съвпадения!</li>
                                                <?php
                                                while ($row = $specialties->fetch_assoc()) {
                                                    echo "<li id='" . $row['specialty_id'] . "' value='" . $row["spec"] . "'>" . $row["specialty"] . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="st-eform" id="st-eform" style="cursor: pointer; padding-right: 30px;" readonly>
                                        <input type="hidden" name="st-eform-id" id="st-eform-id">
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Форма на обучение</label>
                                        <span></span>
                                        <div class="select-dropdown" id="select-eform-dropdown">
                                            <ul id="select-eform">
                                                <?php
                                                while ($row = $formOfEd->fetch_assoc()) {
                                                    echo "<li id='" . $row['form_id'] . "'>" . $row["form_ed"] . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="st-course" id="st-course" style="cursor: pointer; padding-right: 30px;" readonly>
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Курс</label>
                                        <span></span>
                                        <div class="select-dropdown" id="select-course-dropdown">
                                            <ul id="select-course">
                                                <?php
                                                for ($i = 1; $i <= 5; $i += 1) {
                                                    echo "<li id='" . $i . "'>" . $i . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="st-group" id="st-group" style="cursor: pointer; padding-right: 30px;" readonly>
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Група</label>
                                        <span></span>
                                        <div class="select-dropdown" id="select-group-dropdown">
                                            <ul id="select-group" style="max-height: 65px;">
                                                <?php
                                                for ($i = 1; $i <= 10; $i += 1) {
                                                    echo "<li id='" . $i . "'>" . $i . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field object-center">
                                        <button type="submit" name="add-discipline-btn" style="max-width: 350px;">Напред</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="group-next-step" style="display: none;">
                </div>
            </div>
            <div id="add-individual-id" style="display: none;">
                <div class="object-center" style="height: auto;">
                    <div class="container" style="max-width: none; width: 550px;">
                        <div class="wrapper" style="box-shadow: none; background: none;">
                            <div class="form-title">Въвеждане на оценка</div>
                            <form id="add-iGrade-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                                <div class="field">
                                    <input type="text" name="discipline" id="discipline" style="cursor: pointer; padding-right: 30px;">
                                    <input type="hidden" name="discipline-id" id="discipline-id">
                                    <i class="fa fa-chevron-left"></i>
                                    <label>Дисциплина</label>
                                    <span></span>
                                    <div class="select-dropdown" id="select-discipline-dropdown">
                                        <ul id="select-discipline" style="max-height: 115px;">
                                            <li class="result" style="color: #99190b; display: none; cursor: not-allowed;" id="result">Няма съвпадения!</li>
                                            <?php
                                            while ($row = $disciplines->fetch_assoc()) {
                                                echo "<li id='" . $row['discipline_id'] . "'>" . $row["discipline"] . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="field">
                                    <input type="text" name="st-fnum" id="st-fnum" maxlength="10">
                                    <label>Факултетен номер</label>
                                    <span id="fNumError"></span>
                                </div>
                                <div class="field object-center">
                                    <button type="submit" name="add-discipline-btn" style="max-width: 350px;">Напред</button>
                                </div>
                            </form>
                            <div id="next-step" style="display: none;">
                                <fieldset id="st-info">
                                </fieldset>
                                <form id="add-st-grade-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative; margin-top: -15px;">
                                    <div class="field focused">
                                        <input type="date" name="exam-st-date" id="exam-st-date" value="<?php echo date('Y-m-d'); ?>">
                                        <label>Дата</label>
                                        <span></span>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="st-semester" id="st-semester" style="cursor: pointer; padding-right: 30px;" readonly>
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Семестър</label>
                                        <span></span>
                                        <div class="select-dropdown" id="select-st-semester-dropdown">
                                            <ul id="select-st-semester">
                                                <?php
                                                for ($i = 1; $i <= 10; $i += 1) {
                                                    echo "<li>" . $i . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="grade" id="grade" style="cursor: pointer; padding-right: 30px;" readonly>
                                        <input type="hidden" name="grade-id" id="grade-id">
                                        <i class="fa fa-chevron-left"></i>
                                        <label>Оценка</label>
                                        <span></span>
                                        <div class="select-dropdown" id="select-grade-dropdown">
                                            <ul id="select-grade" style="max-height: 85px;">
                                                <li id="-1">Без заверка</li>
                                                <li id="0">Не се явил</li>
                                                <li id="1">Зачита се</li>
                                                <li id="2">Слаб (2)</li>
                                                <li id="3">Среден (3)</li>
                                                <li id="4">Добър (4)</li>
                                                <li id="5">Мн. добър (5)</li>
                                                <li id="6">Отличен (6)</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field object-center">
                                        <button type="submit" name="add-st-grade-btn" style="max-width: 350px;">Запази</button>
                                    </div>
                                </form>
                            </div>
                            <div id="edit-grade" style="display: none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/grades.js?v=<?php echo time(); ?>" type="module"></script>
<script src="../teacher/jsControllers/lastActivity.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/teacher/layout/footer.php'; ?>