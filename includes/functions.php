<?php
session_start();

/**
 * Check if a user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if the current user is admin
 */
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Redirect to a given page
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Escape HTML for output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Flash message system
 */
function setFlash($message) {
    $_SESSION['flash'] = $message;
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
    return '';
}
?>
