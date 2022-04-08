<nav>
    <a href="/e-diary/student/index.php">
        <div class="logo">
            <img src="/e-diary/assets/images/logo.png">
        </div>
    </a>
    <div class="right-menu">
        <div id="unread-msg-id">
            <!-- Unread notifications count will show here -->
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
<div class="dropdown-msg-menu" id="dropdown-msg-menu-id">
    <ul>
        <!-- Notifications will show here -->
    </ul>
</div>