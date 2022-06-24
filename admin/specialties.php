<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/sideMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/serverControllers/specialtyControllers/getSpecialties.php';
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
                        <span class="text">Потърсете специалност...</span>
                        <input type="text" placeholder="Въведете специалност, ОКС или катедра...">
                        <button><i class="fa-solid fa-search"></i></button>
                    </div>
                </div>
                <div class="grades-card" style="padding: 0; height: auto;">
                    <legend style="text-align: center;">Специалности</legend>
                    <table id="grades-table">
                        <thead>
                            <tr>
                                <td>Специалност</td>
                                <td>ОКС</td>
                                <td>Катедра</td>
                                <td>Премахване</td>
                            </tr>
                        </thead>
                        <tbody id="filter-table">
                            <?php while ($row = $specialties->fetch_assoc()) {
                                echo '
                            <tr>
                                <td>' . $row['specialty'] . '</td>
                                <td>' . $row['degree'] . '</td>
                                <td>' . $row['department'] . '</td>
                                <td>
                                    <div class="object-center">
                                        <div class="status poor" id="' . $row['specialty_id'] . '" style="cursor: pointer;">Премахване</div>
                                    </div>
                                </td>
                            </tr>';
                            }
                            ?>
                            <tr></tr>
                        </tbody>
                    </table>
                    <div id="not-found" class="object-center no-grades" style="margin-top: 25px; display: none;">Няма открити специалности!</div>
                </div>
            </div>
            <div id="add-box" style="display: none;">
                <div class="object-center" style="height: auto;">
                    <div class="container" style="max-width: none; width: 550px;">
                        <div class="wrapper" style="box-shadow: none; background: none;">
                            <div class="form-title">Добавяне на специалност</div>
                            <div class="alert alert-success" style="display: none;">
                                <div class="icon">
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    Успешно добавяне на специалност!
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
                            <form id="add-specialty-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" style="position: relative;">
                                <div class="field">
                                    <input type="text" name="specialty-name" id="specialty-name" maxlength="100">
                                    <label>Специалност</label>
                                    <span id="specialtyError"></span>
                                </div>
                                <div class="field">
                                    <input type="text" name="spec-department" id="spec-department" style="cursor: pointer; padding-right: 30px;">
                                    <input type="hidden" name="spec-department-id" id="spec-department-id">
                                    <i class="fa fa-chevron-left"></i>
                                    <label>Катедра</label>
                                    <span></span>
                                    <div class="select-dropdown" id="select-department-dropdown">
                                        <ul id="select-department">
                                            <li class="result" style="color: #99190b; display: none; cursor: not-allowed;" id="result">Няма съвпадения!</li>
                                            <?php
                                            while ($row = $departments->fetch_assoc()) {
                                                echo "<li id='" . $row['department_id'] . "' value='" . $row["dep"] . "'>" . $row["department"] . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="field">
                                    <input type="text" name="spec-degree" id="spec-degree" style="cursor: pointer; padding-right: 30px;" readonly>
                                    <input type="hidden" name="spec-degree-id" id="spec-degree-id">
                                    <i class="fa fa-chevron-left"></i>
                                    <label>ОКС</label>
                                    <span></span>
                                    <div class="select-dropdown" id="select-degree-dropdown">
                                        <ul id="select-degree">
                                            <?php
                                            while ($row = $degrees->fetch_assoc()) {
                                                echo "<li id='" . $row['degree_id'] . "'>" . $row["degree"] . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="field object-center">
                                    <button type="submit" name="add-specialty-btn" style="max-width: 350px;">Добави</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../admin/assets/js/specialties.js?v=<?php echo time(); ?>" type="module"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/admin/layout/footer.php'; ?>