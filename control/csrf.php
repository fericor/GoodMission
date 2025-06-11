<?php
    session_start();
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    function csrf_token() {
        return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    }
    function check_csrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                session_destroy();
                header("Location: ../../login.php");
                die("CSRF token inválido");
            }
        }
    }

    function noLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../login.php");
            exit();
        }
    }

    function isLogged() {
        return isset($_SESSION['user_id']);
    }
    
    function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    function isActive($page) {
        return basename($_SERVER['PHP_SELF']) == $page ? 'text-blue-500' : 'text-gray-500';
    }
