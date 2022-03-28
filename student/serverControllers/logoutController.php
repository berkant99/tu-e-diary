<?php
if (isset($_GET['logout_id'])) {
    session_id($_GET['logout_id']);
    session_start();
    session_destroy();
    header('location: login.php');
    //terminate the current script 
    exit();
}
