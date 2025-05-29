<?php
require_once __DIR__ . '/../../includes/functions.php';

function requireUser() {
    if (!isLoggedIn()) {
        setFlash("Please log in to access this page.");
        redirect('/user/login.php');
    }
}

function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        setFlash("Admin access required.");
        redirect('/admin/login.php');
    }
}
