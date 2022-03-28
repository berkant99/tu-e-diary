<nav>
    <a href="/e-diary/student/index.php">
        <div class="logo">
            <img src="/e-diary/assets/images/logo.png">
        </div>
    </a>
    <div class="right-menu">
        <div class="unread-msg">
            15
        </div>
        <a href="#">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
        </a>
        <div class="user-info">
            <div class="username"><?php echo $_SESSION['name']; ?></div>
            <img src="/e-diary/assets/images/user-icon.jpg">
        </div>
        <div class="logout">
            <a href="login.php?logout_id=<?php echo $_SESSION['id']; ?>">
                <i class="fa-solid fa-arrow-right-from-bracket" id="idx-lgt"></i>
            </a>
        </div>
        <input type="checkbox" id="menu_checkbox">
        <label for="menu_checkbox">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </div>
</nav>
<div class="dropdown-msg-menu">
    <ul>
        <div class="msg">
            <div class="hr-group">
                <li>Ново съобщение от Даяна Димитрова</li>
                <div class="vr-group">
                    <div class="date">22/03/22г.</div>
                    <div class="time">11:05ч.</div>
                </div>
            </div>
        </div>
        <div class="msg">
            <div class="hr-group">
                <li>Ново съобщение от Наско Николов</li>
                <div class="vr-group">
                    <div class="date">22/03/22г.</div>
                    <div class="time">11:05ч.</div>
                </div>
            </div>
        </div>
        <div class="msg">
            <div class="hr-group">
                <li>Ново оценка</li>
                <div class="vr-group">
                    <div class="date">22/03/22г.</div>
                    <div class="time">11:05ч.</div>
                </div>
            </div>
        </div>
        <div class="msg">
            <div class="hr-group">
                <li>Ново оценка</li>
                <div class="vr-group">
                    <div class="date">22/03/22г.</div>
                    <div class="time">11:05ч.</div>
                </div>
            </div>
        </div>
        <div class="msg">
            <div class="hr-group">
                <li>Ново оценка</li>
                <div class="vr-group">
                    <div class="date">22/03/22г.</div>
                    <div class="time">11:05ч.</div>
                </div>
            </div>
        </div>
    </ul>
</div>