<?php 
include '../dbConnect.php';

if(isset($message)){
    foreach($message as $msg){
       echo '
       <div class="message">
          <span>'.$msg.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
    }
}

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
<title>Content Management</title>
<link rel="icon" href="/picture/bicycle.png" type="image/png">
<link rel="stylesheet" href="/css/adminPostmanage.css">
<style>
    
</style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>ADMIN</h2>
        <a href="/Postmanagement.php"><button class="postbtn">Report Management</button></a>

        <a href="/Accounts.php"><button class="Accbtn" style="margin-top: 16px;">Accounts</button></a>

        <a href="/logoutadmin.php"><button class="button logout-button">Logout</button></a>
    </div>
    <div class="content">
        <h2 class="panel-title">Reports</h2>
        <div class="panel">
            <div class="tabs">
                <button class="tab active" onclick="showTab('user')">Account Complaints</button>
                <button class="tab" onclick="showTab('admin')">Content Reports</button>
            </div>
            <button class="add-btn" id="addBtn">Print</button>
            <div class="tab-content active" id="user-tab-content">
<div class="containerr">
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>Email</th>
                <th>Created Date</th>
            </tr>
            <?php
            
            // Fetching data from the database
            $sql = "SELECT * FROM Users";
            $result = mysqli_query($conn, $sql);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td>" . $row["FName"] . "</td>";
                    echo "<td>" . $row["LName"] . "</td>";
                    echo "<td>" . $row["Gender"] . "</td>";
                    echo "<td>" . $row["BirthDate"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["CreatedDate"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No users found</td></tr>";
            }

            // Close the connection
            ?>
        </table>
    </div>
            </div>
            <div class="tab-content" id="admin-tab-content">
            <div class="containerr">
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>Email</th>
                <th>Created Date</th>
            </tr>
            <?php
            
            // Fetching data from the database
            $sql = "SELECT * FROM Users";
            $result = mysqli_query($conn, $sql);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td>" . $row["FName"] . "</td>";
                    echo "<td>" . $row["LName"] . "</td>";
                    echo "<td>" . $row["Gender"] . "</td>";
                    echo "<td>" . $row["BirthDate"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["CreatedDate"] . "</td>";
                    echo "<td><form method='POST' action=''><input type='hidden' name='userID' value='" . $row["ID"] . "'><button type='submit'>Delete</button></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No users found</td></tr>";
            }

            // Close the connection
            mysqli_close($conn);
            ?>
        </table>
    </div>



            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelector('#' + tabName + '-tab-content').classList.add('active');
        document.querySelector('.tab[data-tab="' + tabName + '"]').classList.add('active');
        
        // Hide the Add button when switching to the User Account tab
        if (tabName === 'user') {
            document.getElementById('addBtn').style.display = 'none';
        } else {
            document.getElementById('addBtn').style.display = 'block';
        }
    }
</script>


</body>
</html>
