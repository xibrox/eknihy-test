<?php
    session_start();

    function is_logged_in() {
        return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
    }

    function require_login() {
        if (!is_logged_in()) {
            header('Location: login.php');
            exit;
        }
    }
