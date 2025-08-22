<?php

require_once 'functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateLink($_POST['id'], $_POST['url'], $_POST['description'], $_POST['category']);
    header('Location: index.php');
    exit;
}

?>
