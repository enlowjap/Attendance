<?php
    include '../dbConnect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_ID = isset($_COOKIE['ID']) ? $_COOKIE['ID'] : '';
    $subject = $_POST['subject']; // Report subject (1 for Post, 2 for User)
    $description = $_POST['descript'];
    $userID = $_POST['UserID'];
    $postID = $_POST['PostID'];

    if (!empty($complaint_ID) && !empty($subject) && !empty($userID) && !empty($postID)) {
        if($subject == 1){
            $report_query = "INSERT INTO PostReports (postID, UserID, ReportDescription) VALUES ('$postID', '$complaint_ID', '$description')";
        }else{
            $report_query = "INSERT INTO accountcomplaintreport (UserID, UserReceiverID, ReportDescription) VALUES ('$complaint_ID', '$userID', '$description')";
        }
        // Execute the query
        if (mysqli_query($conn, $report_query)) {
            session_start();
            $message = array();
            $message[] = "Report submitted successfully";
            $_SESSION['message'] = $message;
            header('location: ../like_and_post_test.php');
            exit();
        } else {
            $message[] = "Error: " . $report_query . "<br>" . mysqli_error($conn);
        }
    } else {
        $message[] = "Error: Missing required fields";
    }
}
?>
