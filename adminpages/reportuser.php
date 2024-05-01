<?php
    include '../dbConnect.php';

    // Retrieve user ID from cookie
    $user_ID = isset($_COOKIE['ID']) ? $_COOKIE['ID'] : '';

    // Retrieve user receiver ID from form submission
    $user_complaintreceiver = isset($_POST['userID']) ? $_POST['userID'] : '';

    // Retrieve description from form submission
    $description = isset($_POST['descript']) ? $_POST['descript'] : '';

    // Check if all required fields are provided
    if (!empty($user_ID) && !empty($user_complaintreceiver) && !empty($description)) {
        // Prepare the SQL query to insert data into the table
        $report_query = "INSERT INTO accountcomplaintreport (UserID, UserReceiverID, ReportDescription) VALUES ('$user_ID', '$user_complaintreceiver', '$description')";

        // Execute the query
        if (mysqli_query($conn, $report_query)) {
            $message[] = "Report submitted successfully";
            header('location: ../adminpages/testaccountcomplaint.php');
        } else {
            $message[] = "Error: " . $report_query . "<br>" . mysqli_error($conn);
        }
    } else {
        $message[] = "Error: Missing required fields";
    }
?>
