<?php
require_once 'db_config.php';

function getDB() {
    static $conn = null;
    if ($conn === null) {
        $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die("Conexiune esuata: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, 'utf8mb4');
    }
    return $conn;
}
?>