<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit();
} else if ($_SESSION['firstLogin'] == FALSE) {
    header('location: first-signin');
    exit();
} else if (!isset($_SESSION['verified'])) {
    header('location: email-verification');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/sideMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/serverControllers/gradesController.php';
?>
<div class="main card-cntr grades" style="min-width: 500px;">
    <div class="box">
        <div class="card">
            <div class="grades-card">
                <legend>Оценки</legend>
                <?php if ($result->num_rows > 0) : ?>
                    <div class="hr-group" style="justify-content: left;">
                        <div class="slct-lbl">Семестър:</div>
                        <select id="slct-smstr">
                            <option value="0">Всички</option>
                            <?php
                            for ($i = 1; $i <= 10; $i++)
                                echo "<option value=" . $i . ">" . $i . "</option>";
                            ?>
                        </select>
                    </div>
                    <table id="grades-table">
                        <thead>
                            <tr>
                                <td>Дисциплина</td>
                                <td>Оценка</td>
                                <td>Дата</td>
                                <td>Семестър</td>
                                <td>Преподавател</td>
                            </tr>
                        </thead>
                        <tbody id="filter-smstr">
                            <?php while ($row = $result->fetch_assoc()) {
                                echo '
                        <tr>
                            <td>' . $row['discipline'] . '</td>
                            <td><div class="status ' . getStatus($row['grade']) . '">' . getGrade($row['grade']) . '</div></td>
                            <td>' . date("d.m.Y", strtotime($row['date'])) . '</td>
                            <td>' . $row['semester'] . '</td>
                            <td><a id="' . $row['teacher_id'] . '">' . $row['teacher'] . '</a></td>
                        </tr>';
                            }
                            ?>
                            <tr>
                                <td>Общ успех до момента</td>
                                <td><?php echo number_format($avrg, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <script src="../student/assets/js/grades.js?v=<?php echo time(); ?>" type="module"></script>
                <?php else : ?>
                    <div class="object-center no-grades">
                        Все още нямате въведени оценки
                    </div>
                <?php endif; ?>
                <div id="no-grades" class="object-center no-grades" style="margin-top: 25px;"></div>
            </div>
        </div>
    </div>
</div>
<script src="../student/jsControllers/lastActivity.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>