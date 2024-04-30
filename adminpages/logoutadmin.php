<?php

   include 'connect.php';

   setcookie('user_id', '', time() - 1, '/');

   header('location:../AdminLogin.php');

?>