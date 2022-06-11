<div class="nav-menu">
    <div>
        <ul>
            <li>
                <a href="students.php">
                    <span class="icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </span>
                    <span class="title">
                        Студенти
                    </span>
                </a>
            </li>
            <li>
                <a href="teachers.php">
                    <span class="icon">
                        <i class="fa-solid fa-person-chalkboard"></i>
                    </span>
                    <span class="title">
                        Преподаватели
                    </span>
                </a>
            </li>
            <li>
                <a href="login.php?logout_id=<?php echo $_SESSION['id']; ?>">
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