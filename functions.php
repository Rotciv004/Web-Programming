<?php
require_once 'db_connection.php';
session_start();

// 1. Autentificare
function login($username, $password) {
    $conn = getDB();
    $sql  = "SELECT id, password_hash FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash);
    if (mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            return true;
        }
    }
    mysqli_stmt_close($stmt);
    return false;
}

// 2. Verificare sesiune
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// 3. Logout
function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}

// 4. Adaugă link
function addLink($url, $description, $category) {
    $conn = getDB();
    $sql  = "INSERT INTO links (user_id, url, description, category, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isss', $_SESSION['user_id'], $url, $description, $category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// 5. Modifică link
function updateLink($id, $url, $description, $category) {
    $conn = getDB();
    $sql  = "UPDATE links SET url = ?, description = ?, category = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssiii', $url, $description, $category, $id, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// 6. Şterge link
function deleteLink($id) {
    $conn = getDB();
    $sql  = "DELETE FROM links WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// 7. Număr total de pagini
function getTotalPages($category = null, $perPage = 4) {
    $conn = getDB();
    if ($category) {
        $sql  = "SELECT COUNT(*) FROM links WHERE user_id = ? AND category = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'is', $_SESSION['user_id'], $category);
    } else {
        $sql  = "SELECT COUNT(*) FROM links WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return ceil($total / $perPage);
}

// 8. Obţine linkuri pentru pagină + categorie
function getLinks($page = 1, $category = null, $perPage = 4) {
    $offset = ($page - 1) * $perPage;
    $conn   = getDB();
    if ($category) {
        $sql  = "SELECT id, url, description, category 
                 FROM links 
                 WHERE user_id = ? AND category = ? 
                 ORDER BY created_at DESC 
                 LIMIT ? OFFSET ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'isii', $_SESSION['user_id'], $category, $perPage, $offset);
    } else {
        $sql  = "SELECT id, url, description, category 
                 FROM links 
                 WHERE user_id = ? 
                 ORDER BY created_at DESC 
                 LIMIT ? OFFSET ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $_SESSION['user_id'], $perPage, $offset);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $links  = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $links;
}
?>