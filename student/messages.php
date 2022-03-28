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
<div class="main msg-cntr">
    <div class="box">
        <div class="card">
            <div class="hr-group">
                <div class="user-box">
                    <div class="search">
                        <span class="text">Открийте нови хора...</span>
                        <input type="text" placeholder="Въведете име...">
                        <button><i class="fa-solid fa-search"></i></button>
                    </div>
                    <div class="alert alert-error" id="usr-not-found-err">
                        <div class="icon">
                            <i class="fa fa-frown-o" style="border: none; font-size: 28px;" aria-hidden="true"></i>
                        </div>
                        <div class="text">
                            Не успяхме да намерим такъв потребител
                        </div>
                    </div>
                    <div class="users-list">
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot '. $offline .'">
                                <i class="fas fa-circle"></i>
                                <span class="status-text">Offline</span>
                            </div>
                        </a>
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i>
                                <span class="status-text">Active</span>
                            </div>
                        </a>
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot offline"><i class="fas fa-circle"></i>
                                <span class="status-text">Offline</span>
                            </div>
                        </a>
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                        </a>
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                        </a>
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                        </a>
                        <a href="chat.php?user_id='. $row['unique_id'] .'">
                            <div class="content">
                                <img src="/e-diary/assets/images/user-icon.jpg" alt="">
                                <div class="details">
                                    <span>Dayana Dimitrova</span>
                                    <p>hello</p>
                                </div>
                            </div>
                            <div class="status-dot '. $offline .'">
                                <i class="fas fa-circle"></i>

                            </div>
                        </a>
                    </div>
                </div>
                <div class="msg-box">Chat here</div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/chat.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>