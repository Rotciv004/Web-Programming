<?php
require_once 'functions.php';

require_login();
deleteLink($_GET['id']);
header('Location: index.php');

exit;
?>