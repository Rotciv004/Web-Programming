<?php
require_once 'functions.php';
session_start();

// Dacă nu e logat
if (empty($_SESSION['user_id'])) 
{
    header('Location: login.php');
    exit;
}

// Dacă e logat
header('Location: index.php');
exit;
?>