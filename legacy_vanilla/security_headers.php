<?php
/**
 * Security Helpers for WellMind LK
 * Handles CSRF Protection and Security Headers
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate a CSRF token if it doesn't exist
 */
function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify a CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate a hidden input field with the CSRF token
 */
function csrf_field() {
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(get_csrf_token()) . '">';
}

/**
 * Basic security headers
 */
function set_security_headers() {
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
}

set_security_headers();
?>
