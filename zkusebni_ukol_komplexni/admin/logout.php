<?php
require_once '../includes/auth.php';

session_unset();      // odstraní všechny proměnné ze session
session_destroy();    // zničí session

header('Location: login.php');
exit;
