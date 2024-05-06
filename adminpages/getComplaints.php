<?php 
include '../dbConnect.php'; // Include your database connection file

// Retrieve the userID parameter from the URL
$userID = $_GET['userID'];

// Initialize an empty array to store complaint data
$complaints = [];

// Prepare the SQL query
$sql = "SELECT Users.ID, Users.FName, Users.LName, Users.CreatedDate, accountcomplaintreport.ReportDescription
        FROM Users
        LEFT JOIN accountcomplaintreport ON Users.ID = accountcomplaintreport.UserID AND accountcomplaintreport.UserReceiverID = $userID";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch data from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add each row of data to the complaints array
        $complaints[] = $row;
    }
    // Free result set
    mysqli_free_result($result);
}

// Close the connection
mysqli_close($conn);

// Encode the complaints array as JSON and return it
echo json_encode($complaints);
?>