<?php

include '../dbConnect.php';

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';
    header('location:AdminLogin.php');}

    // Query to get counts
$userCountQuery = "SELECT COUNT(*) as userCount FROM Users";
$postCountQuery = "SELECT COUNT(*) as postCount FROM Posts";
$postReportCountQuery = "SELECT COUNT(*) as postReportCount FROM PostReports";
$userReportCountQuery = "SELECT COUNT(*) as userReportCount FROM accountcomplaintreport";

// Execute queries
$userCountResult = mysqli_query($conn, $userCountQuery);
$postCountResult = mysqli_query($conn, $postCountQuery);
$userReportCountResult = mysqli_query($conn, $userReportCountQuery);
$postReportCountResult = mysqli_query($conn, $postReportCountQuery);

// Fetch counts
$userCount = mysqli_fetch_assoc($userCountResult)['userCount'];
$postCount = mysqli_fetch_assoc($postCountResult)['postCount'];
$userReportCount = mysqli_fetch_assoc($userReportCountResult)['userReportCount'];
$postReportCount = mysqli_fetch_assoc($postReportCountResult)['postReportCount'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/Admindboard.css">
    <title>Dashboard</title>
</head>
<body>
<?php 
include '../adminpages/Sadminnavbar.php';
?>

<div class="mcont_dboard">
    <div class="welMsg">
        <div>
            <h1>Welcome Super Adminstrator</h1>
        </div>
        <div>
            <h2>Today's Status</h2>
        </div>
    </div>

    <div class="statcount">
        <div class="sc">
        <label name="user"><?php echo $userCount; ?></label>
        <img src="../picture/user.png" alt="Menu Icon" class="icon"></a>
        <p>Users Count</p>
        </div>

        <div class="sc">
        <label name="post"><?php echo $postCount; ?></label>
        <img src="../picture/post.png" alt="Menu Icon" class="icon">
        <p>Post Count</p>
        </div>

        <div class="sc">
        <label name="userrep"><?php echo $userReportCount; ?></label>
        <img src="../picture/man.png" alt="Menu Icon" class="icon">
        <p>Users Reported</p>
        </div>

        <div class="sc">
        <label name="postrep"><?php echo $postReportCount; ?></label>
        <img src="../picture/complaint.png" alt="Menu Icon" class="icon">
        <p>Posts Reported</p>
        </div>
    </div>


</div>
</body>
</html>