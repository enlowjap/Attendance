<?php 
session_start();
include '../dbConnect.php';

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';
    header('location:AdminLogin.php');}


function deleteUser($userID) {
    global $conn; // Access the database connection inside the function
    
    // Prepare and execute the delete query
    $delete_query = "DELETE FROM Users WHERE ID = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $userID); // "i" indicates integer type for the user ID
    if ($stmt->execute()) {
        return true; // Return true if deletion is successful
    } else {
        return false; // Return false if deletion fails
    }
}

// Check if form is submitted and the user ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    // Call the deleteUser function
    if (deleteUser($userID)) {
         $message[] = 'User deleted successfully.';
    } else {
         $message[] = 'Unable to delete user.';
    }
}

function deleteAdmin($adminID) {
    global $conn; // Access the database connection inside the function
    
    // Prepare and execute the delete query
    $delete_query = "DELETE FROM administrator WHERE ID = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $adminID); // "i" indicates integer type for the user ID
    if ($stmt->execute()) {
        return true; // Return true if deletion is successful
    } else {
        return false; // Return false if deletion fails
    }
}

// Check if form is submitted and the user ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adminID'])) {
    $adminID = $_POST['adminID'];
    // Call the deleteUser function
    if (deleteAdmin($adminID)) {
         $message[] = 'Admin user deleted successfully.';
    } else {
         $message[] = 'Unable to delete user.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accounts</title>
<link rel="icon" href="/picture/bicycle.png" type="image/png">
<link rel="stylesheet" href="/css/adminAccounts.css">
</head>

<body> 

<?php 
if(isset($_SESSION['message'])){
    
    $message = $_SESSION['message'];

    
    if(is_array($message)){
        
        foreach($message as $msg){
           echo '
           <div class="message">
              <span>'.$msg.'</span>
              <i class="fas fa-times" onclick="removeMessage(this.parentElement);"></i>
           </div>
           ';
        }
    } else {
        
        echo '
        <div class="message">
           <span>'.$message.'</span>
           <i class="fas fa-times" onclick="removeMessage(this.parentElement);"></i>
        </div>
        ';
    }

    
    unset($_SESSION['message']);
}
?>

<script>
    function removeMessage(element) 
        {
        element.classList.add("hide");
    }
</script>

<div class="container">
    <div class="sidebar">
        <h2>ADMIN</h2>
        <a href="/Postmanagement.php"><button class="postbtn">Reports Management</button></a>

        <a href="/Accounts.php"><button class="Accbtn" style="margin-top: 16px;">Accounts</button></a>

        <a href="/logoutadmin.php"><button class="button logout-button">Logout</button></a>
    </div>
    <div class="content">
        <h2 class="panel-title">Accounts</h2>
        <div class="panel">
            <div class="tabs">
                <button class="tab active" onclick="showTab('user')">User Account</button>
                <button class="tab" onclick="showTab('admin')">Admin Account</button>
            </div>
            
            

<div class="tab-content active" id="user-tab-content">         
<div class="containerr">

<button class="add-btn" id="addUserBtn" >Add User</button>
<!-- Form Popup -->
<div class="formm-popup" id="myForm">
  <form action="submituser.php" method="post" class="formm-container">
    <h2>Add User</h2>

    <label for="fname"><b>First Name</b></label>
    <input type="text" placeholder="Enter First Name" name="fname" required>

    <label for="lname"><b>Last Name</b></label>
    <input type="text" placeholder="Enter Last Name" name="lname" required>

    <label for="gender"><b>Gender</b></label>
    <select name="gender" required>
      <option value="Female">Female</option>
      <option value="Male">Male</option>
      <option value="Others">Others</option>
    </select>

    <label for="birthdate"><b>Birth Date</b></label>
    <input type="date" name="birthdate" required>

    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button type="submit" class="btn">Add</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>

<script> 
document.getElementById("addUserBtn").addEventListener("click", function() {
  document.getElementById("myForm").style.display = "block";
});

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

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
            $sql = "SELECT * FROM Users WHERE Status = 'active' ";
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
                    echo "<td>
                            <form id='deleteForm" . $row["ID"] . "' method='POST' action=''>
                                <input type='hidden' name='userID' value='" . $row["ID"] . "'>
                                <button type='button' onclick='confirmDelete(" . $row["ID"] . ")'>Delete</button>
                            </form>
                        </td>";
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

            <div class="tab-content" id="admin-tab-content">
            <div class="containerr">
            <button class="add-btn" id="addAdminBtn" onclick="addAdmin()">Add Admin</button>
            <script>
                function confirmDelete(userID) {
                    if (confirm("Are you sure you want to delete this user?")) {
                        document.getElementById("deleteForm" + userID).submit();
                    }
                }

                function addAdmin() {
                    // Show a prompt to enter admin details
                    var name = prompt("Enter Admin Name:");
                    var password = prompt("Enter Password:");

                    // If user clicked cancel or entered empty value, exit function
                    if (!name || !password) {
                        return;
                    }

                    // Send data to PHP script using AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "insert_admin.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Display result or handle any errors
                            alert(xhr.responseText);
                            // Reload the page after successful addition
                            window.location.reload();
                        }
                    };
                    xhr.send("name=" + name + "&password=" + password);
                }
            </script>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Password</th>
            </tr>
            <?php
            // Database connection
            include 'dbConnect.php';

            // Fetching data from the database
            $sql = "SELECT * FROM Administrator";
            $result = mysqli_query($conn, $sql);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["Password"] . "</td>";
                    if ($row["ID"] !== '1'){
                        echo "<td><form method='POST' action=''><input type='hidden' name='adminID' value='" . $row["ID"] . "'><button type='submit'>Delete</button></form></td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No administrators found</td></tr>";
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
    }
</script>




</body>
</html>
