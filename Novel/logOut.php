<?php
session_start();
session_destroy();
$redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '/';
header("Location: " . $redirect_url);
?>