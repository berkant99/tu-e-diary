<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_GET['logout_id'])) {
    $conn->query("UPDATE st_login SET status = 'Offline' WHERE facultyNumber = '" . $_GET['logout_id'] . "'");
    session_id($_GET['logout_id']);
    session_start();
    session_destroy();
    session_commit();
    header('location: login.php');
    //terminate the current script 
    exit();
}
