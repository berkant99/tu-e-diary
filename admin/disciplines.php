<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/sideMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/disciplinesControllers/getDisciplines.php';
?>
<div class="main card-cntr admin">
    <div class="box" style="min-width: 750px;">
        <div class="card">
            <div class="hr-group" id="btn-group">
                <button id="search-btn" class="settings-title">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Търсене
                </button>
                <button id="add-btn" class="settings-title">
                    <i class="fa-solid fa-plus"></i>
                    Добавяне
                </button>
            </div>
            <div id="search-box">
                <div class="object-center">
                    <div class="search" style="width: 40%; margin: 0;">
                        <span class="text">Потърсете дисциплина...</span>
                        <input type="text" placeholder="Въведете дисциплина...">
                        <button><i class="fa-solid fa-search"></i></button>
                    </div>
                </div>
                <div class="grades-card" style="padding: 0; height: auto;">
                    <legend style="text-align: center;">Дисциплини</legend>
                    <table id="grades-table">
                        <thead>
                            <tr>
                                <td>Дисциплина</td>
                                <td>Премахване</td>
                            </tr>
                        </thead>
                        <tbody id="filter-table">
                            <?php while ($row = $disciplines->fetch_assoc()) {
                                echo '
                            <tr>
                                <td>' . $row['discipline'] . '</td>
                                <td>
                                    <div class="object-center">
                                        <div class="status poor" id="' . $row['discipline_id'] . '" style="cursor: pointer;">Премахване</div>
                                    </div>
                                </td>
                            </tr>';
                            }
                            ?>
                            <tr></tr>
                        </tbody>
                    </table>
                    <div id="not-found" class="object-center no-grades" style="margin-top: 25px; display: none;">Няма открити дисциплини!</div>
                </div>
            </div>
            <div id="add-box" style="display: none;">
                <div class="object-center" style="height: auto;">
                    <div class="container" style="max-width: none; width: 550px;">
                        <div class="wrapper" style="box-shadow: none; background: none;">
                            <div class="form-title">Добавяне на нова дисциплина</div>
                            <div class="alert alert-success" style="display: none;">
                                <div class="icon">
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    Успешно добавяне на нова дисциплина!
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
                            <form id="add-discipline-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                                <div class="field">
                                    <input type="text" name="discipline-name" id="discipline-name" maxlength="100">
                                    <label>Дисциплина</label>
                                    <span id="disciplineError"></span>
                                </div>
                                <div class="field object-center">
                                    <button type="submit" name="add-discipline-btn" style="max-width: 350px;">Добави</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../admin/assets/js/disciplines.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/footer.php'; ?>