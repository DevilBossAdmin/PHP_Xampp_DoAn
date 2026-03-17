<?php
function admin_session_start_if_needed() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && !empty($_SESSION['admin_id']);
}

function require_admin_login() {
    admin_session_start_if_needed();
    if (!is_admin_logged_in()) {
        header('location:admin_login.php');
        exit();
    }
}

function set_admin_session(array $admin) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = (int)$admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['admin_email'] = $admin['email'];
    $_SESSION['admin_photo'] = $admin['photo'];
}

function clear_admin_session() {
    unset($_SESSION['admin_logged_in'], $_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['admin_email'], $_SESSION['admin_photo']);
}
?>