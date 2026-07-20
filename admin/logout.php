<?php
session_start();

unset($_SESSION['admin_logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['role_id']);
unset($_SESSION['role']);

header("Location: login.php");
exit;