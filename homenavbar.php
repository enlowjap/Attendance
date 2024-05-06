<?php

include 'dbConnect.php';

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';
    header('location:AdminLogin.php');}

    $userid = isset($_COOKIE['ID']) ? $_COOKIE['ID'] : '';
    $fname = '';
    $lname = '';

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT FName, LName FROM Users WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['FName'];
        $lname = $row['LName'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="/css/homenavbar.css">
</head>
<body>
<div class="SAnavbar">

<div class="menu">
    <div><a href="/adminpages/SAdashboard.php"><img src="../picture/bicycle.png" alt="Menu Icon" class="menu-icon"></a></div>
  <div class="dropdown">
    <button class="dropdown-btn">&#9776;</button>
    <div class="dropdown-content">
      <a href="UserProfile.php">Profile</a>
      <!-- my route posts para ma edit yung post ng user at mag delete -->
      <a href="#">My Route Posts</a> 
    </div>
  </div>
</div>

<div class="lgbttn">
<p>Hello! <?php echo ucwords($lname) ; ?>, <?php echo ucwords($fname); ?></p>
<a href="logout.php"><button class="button logout-button">Logout</button></a>
</div>

</div>
</body>
</html>