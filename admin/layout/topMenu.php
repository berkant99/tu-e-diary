<nav>
    <a href="/e-diary/admin/home">
        <div class="logo">
            <img src="/e-diary/assets/images/logo.png">
        </div>
    </a>
    <div class="right-menu">
        <div class="user-info" style="margin-right: 15px;">
            <div class="username"><?php echo $_SESSION['name']; ?></div>
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