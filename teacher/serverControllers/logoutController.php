<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/dbConnection.php';
if (isset($_GET['logout_id'])) {
    session_id($_GET['logout_id']);
    session_start();
    session_destroy();
    session_commit();
    header('location: login');
    //terminate the current script 
    exit();
}