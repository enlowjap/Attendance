<?php

include '../dbConnect.php';

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';
    header('location:AdminLogin.php');}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="/css/adminnavbar.css">
</head>
<body>
<div class="SAnavbar">

<div class="menu">
    <div><a href="/adminpages/SAdashboard.php"><img src="../picture/bicycle.png" alt="Menu Icon" class="menu-icon"></a></div>
  <div class="dropdown">
    <button class="dropdown-btn">&#9776;</button>
    <div class="dropdown-content">
      <a href="/adminpages/Postmanagement.php">Post Management</a>
      <a href="/adminpages/Accounts.php">Account Management</a>
      <a href="#">Ticket Management</a>
    </div>
  </div>
</div>

<div class="lgbttn">
<a href="/adminpages/logoutadmin.php"><button class="button logout-button">Logout</button></a>
</div>

</div>
</body>
</html>