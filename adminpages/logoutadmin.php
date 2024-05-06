<?php

include '../dbConnect.php';

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the cookie by setting its expiration time to the past
setcookie('ID', '', time() - 1, '/');

header('location:../adminpages/AdminLogin.php');
exit(); // Ensure script stops executing after redirection
?>