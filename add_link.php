<?php
require_once 'functions.php';

require_login();
addLink($_POST['url'], $_POST['description'], $_POST['category']);
header('Location: index.php');
exit;
?>