<?php
require_once 'functions.php';
require_login();


$page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$category = !empty($_GET['category']) ? $_GET['category'] : null;
$perPage  = 4;

$links      = getLinks($page, $category, $perPage);
$totalPages = getTotalPages($category, $perPage);

header('Content-Type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<data>\n";
echo "  <page current='$page' total='$totalPages'/>\n";
echo "  <links>\n";
foreach ($links as $l) {
    echo "    <link>\n";
    echo "      <id>{$l['id']}</id>\n";
    echo "      <url>" . htmlspecialchars($l['url']) . "</url>\n";
    echo "      <desc>" . htmlspecialchars($l['description']) . "</desc>\n";
    echo "      <cat>" . htmlspecialchars($l['category']) . "</cat>\n";
    echo "    </link>\n";
}
echo "  </links>\n";
echo "</data>";
?>