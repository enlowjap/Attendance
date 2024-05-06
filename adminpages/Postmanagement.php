<?php 
include '../dbConnect.php';

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';
    header('location:AdminLogin.php');}

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

<?php 
include '../adminpages/Sadminnavbar.php';
?>

<div class="container">
    <div class="content">
        <h2 class="panel-title">Reports</h2>
        <div class="panel">
            <div class="tabs">
                    <button class="tab active" data-tab="user" onclick="showTab('user')">Account Complaints</button>
                    <button class="tab" data-tab="admin" onclick="showTab('admin')">Posts Reports</button>
                    <script>
                        function showTab(tabName) {
                            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
                            document.querySelectorAll('.tab-content').forEach(tabContent => tabContent.classList.remove('active'));

                            document.querySelector('.tab[data-tab="' + tabName + '"]').classList.add('active');
                            document.querySelector('#' + tabName + '-tab-content').classList.add('active');

                            // Hide the Add button when switching to the User Account tab
                            if (tabName === 'user') {
                                document.getElementById('addBtn').style.display = 'none';
                            } else {
                                document.getElementById('addBtn').style.display = 'block';
                            }
                        }
                    </script>
            </div>
            <button class="add-btn" id="addBtn">Print</button>
            <div class="tab-content active" id="user-tab-content">
<div class="containerr">

    <!-- Complaint Table Popup -->
    <div id="complaintTable" class="formm-popup">
        <div class="formm-container">
            <h2>User Complaints</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Complaint Description</th>
                    </tr>
                </thead>
                <tbody id="complaintTableBody">
                    <!-- Complaints will be dynamically populated here -->
                </tbody>
            </table>
            <button type="button" class="btn cancel" onclick="closeComplaintTable()">Close</button>
        </div>
    </div>

    <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Created Date</th>
                <th>Number of Complaints</th>
            </tr>
            <?php
                // Fetching data from the database
                $sql = "SELECT Users.ID, Users.FName, Users.LName, Users.CreatedDate, ReportCountbyUserRec.NumberOfReports
                FROM Users
                LEFT JOIN ReportCountbyUserRec ON Users.ID = ReportCountbyUserRec.UserReceiverID
                ORDER BY ReportCountbyUserRec.NumberOfReports DESC";
                $result = mysqli_query($conn, $sql);

                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["ID"] . "</td>";
                        echo "<td>" . $row["FName"] . "</td>";
                        echo "<td>" . $row["LName"] . "</td>";
                        echo "<td>" . $row["CreatedDate"] . "</td>";
                        echo "<td>" . $row["NumberOfReports"] . "</td>";
                        echo "<td> <button type='button' onclick='ViewComplaint(" . $row["ID"] . ")'>View</button></td>";
                        echo "<td>
                            <form id='deleteForm" . $row["ID"] . "' method='POST' action=''>
                                <input type='hidden' name='userID' value='" . $row["ID"] . "'>
                                <button type='button' onclick='confirmDelete(" . $row["ID"] . ")'>Diactivate</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No users found</td></tr>";
                }
            ?>
        </table>

        <script>
            function ViewComplaint(userID) {
                // Open the complaint table popup
                document.getElementById("complaintTable").style.display = "block";

                // Fetch complaints for the user ID using AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Parse the JSON response
                        var complaints = JSON.parse(this.responseText);

                        // Populate the complaint table
                        var tableBody = document.getElementById("complaintTableBody");
                        tableBody.innerHTML = ""; // Clear existing rows

                        // Loop through complaints and add rows to the table
                        complaints.forEach(function(complaint) {
                            var row = "<tr>";
                            row += "<td>" + complaint.ID + "</td>";
                            row += "<td>" + complaint.FName + "</td>";
                            row += "<td>" + complaint.LName + "</td>";
                            row += "<td>" + complaint.ReportDescription + "</td>";
                            row += "</tr>";
                            tableBody.innerHTML += row;
                        });
                    }
                };
                xhr.open("GET", "getComplaints.php?userID=" + userID, true);
                xhr.send();
            }

            function closeComplaintTable() {
                // Close the complaint table popup
                document.getElementById("complaintTable").style.display = "none";
            }
        </script>
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

</body>
</html>
