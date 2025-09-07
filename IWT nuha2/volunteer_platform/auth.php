<?php
// auth.php - session helpers and guards
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: index.php?msg=Please+login');
        exit;
    }
}

function require_role($role) {
    require_login();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        header('Location: home.php?msg=Access+denied');
        exit;
    }
}
?>
