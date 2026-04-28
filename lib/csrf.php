<?php
// CSRF token issuance and validation.
// Token lives in $_SESSION; included as a <meta> tag for AJAX (read in JS,
// sent as X-CSRF-Token header) and as a hidden input for form submits.
//
// Important: this file starts the session at include time so the session
// cookie can be set in headers before any HTML output. Entry pages MUST
// `require_once` this file before emitting any markup.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function csrf_start_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function csrf_token()
{
    csrf_start_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_meta()
{
    echo '<meta name="csrf-token" content="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">' . "\n";
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

// Inline script to wire jQuery AJAX so every POST carries the token as a header.
// Must be emitted AFTER jQuery loads.
function csrf_ajax_setup_script()
{
    return '<script>jQuery(function($){$.ajaxSetup({headers:{"X-CSRF-Token":$("meta[name=\'csrf-token\']").attr("content")}});});</script>';
}

// Aborts with 403 JSON if the request lacks a valid token. Accepts either
// X-CSRF-Token header (AJAX) or csrf_token POST field (form submit).
function csrf_check()
{
    csrf_start_session();
    $expected = $_SESSION['csrf_token'] ?? '';
    $provided = $_SERVER['HTTP_X_CSRF_TOKEN']
        ?? $_POST['csrf_token']
        ?? '';

    if (empty($expected) || !is_string($provided) || !hash_equals($expected, $provided)) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failure', 'message' => 'Invalid CSRF token']);
        exit;
    }
}
