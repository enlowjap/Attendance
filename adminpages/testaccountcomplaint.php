<?php 
include '../dbConnect.php'; 

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';

header('location:../Login.php');}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/adminAccounts.css">  
    <title>Document</title>
</head>
<body>
<a href="../logout.php"><button class="button logout-button">Logout</button></a>
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
                            echo "<td> <button type='button' onclick='reportUser(" . $row["ID"] . ", \"" . $row["FName"] . "\", \"" . $row["LName"] . "\")'>Report</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found</td></tr>";
                    }

                    // Close the connection
                    mysqli_close($conn);
            ?>
            <script>
                function reportUser(userID, fName, lName) {
                    // Open the report form
                    document.getElementById("myForm").style.display = "block";

                    // Set the first name and last name in the form labels
                    document.getElementById("fname").textContent = fName;
                    document.getElementById("lname").textContent = lName;

                    // Set the user ID in the hidden input field
                    document.getElementById("userID").value = userID;
                }

                function closeForm() {
                    // Close the report form
                    document.getElementById("myForm").style.display = "none";
                }
            </script>


            <!-- Form Popup -->
            <div class="formm-popup" id="myForm">
                <form action="../adminpages/reportuser.php" method="post" class="formm-container">
                    <h2>Report User</h2>
                    <input type="hidden" id="userID" name="userID" value="">
                    <label><b>First Name:</b> <span id="fname"></span></label>
                    <br>
                    <label><b>Last Name:</b> <span id="lname"></span></label>
                    <br>
                    <label for="descript"><b>Description:</b></label>
                    <input type="text" name="descript" required>
                    <button type="submit" class="btn">Submit</button>
                    <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
                </form>
            <script>
                function submitForm() {
                    var userID = document.getElementById("userID").value;
                    // Validate if userID exists
                    if (!userID) {
                        alert("User ID is missing!");
                        return false; // Prevent form submission
                    }
                    return true; // Allow form submission
                }
            </script>
            </div>


</body>
</html>