<?php
session_start();
include 'dbConnect.php'; // Include your database connection file

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reportDescription'])) {
    $userID = $_SESSION['user_id']; // Assuming user ID is stored in session

    $postID = 1; // Example: Replace with actual post ID
    $reportDescription = $_POST['reportDescription'];

    // Perform further validation and sanitization of the data here

    // Example: Insert the report data into the database
    $stmt = $conn->prepare("INSERT INTO PostReports (postID, UserID, ReportDescription) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $postID, $userID, $reportDescription);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        $errors[] = "Failed to submit report.";
    }
} else {
    $errors[] = "Invalid request.";
}

// Return errors if any
echo json_encode(['success' => false, 'errors' => $errors]);
exit;
?>
