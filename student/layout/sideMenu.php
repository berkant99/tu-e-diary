<div class="nav-menu">
    <div>
        <ul>
            <li>
                <a href="home">
                    <span class="icon">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    <span class="title">
                        Начало
                    </span>
                </a>
            </li>
            <li>
                <a href="messages">
                    <span class="icon">
                        <i class="fa-solid fa-comments" aria-hidden="true"></i>
                    </span>
                    <span class="title">
                        Съобщения
                    </span>
                </a>
            </li>
            <li>
                <a href="grades">
                    <span class="icon">
                        <i class="fa-solid fa-book"></i>
                    </span>
                    <span class="title">
                        Оценки
                    </span>
                </a>
            </li>
            <li>
                <a href="teachers">
                    <span class="icon">
                        <i class="fa-solid fa-person-chalkboard"></i>
                    </span>
                    <span class="title">
                        Преподаватели
                    </span>
                </a>
            </li>
            <li>
                <a href="settings">
                    <span class="icon">
                        <i class="fa-solid fa-gear"></i>
                    </span>
                    <span class="title">
                        Настройки
                    </span>
                </a>
            </li>
            <li>
                <a href="login?logout_id=<?php echo $_SESSION['id']; ?>">
                    <span class="icon">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </span>
                    <span class="title">
                        Изход
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <div class="copyright">
        &copy; <?php echo date('Y') ?> ТУ-Варна
    </div>
</div>