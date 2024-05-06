<?php
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $user_ID = isset($_COOKIE['ID']) ? $_COOKIE['ID'] : '';
    $description = $_POST["description"];
    $status = "active";
    $maplink = $_POST["link"];

    // File details
    $photo_tmp_name = $_FILES["photo"]["tmp_name"];

    // Read the file content
    $photo_data = file_get_contents($photo_tmp_name);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO Posts (ID, Content, Image,Link, Status, Created_at) VALUES (?, ?,?, ?, ?, NOW())");

    // Bind parameters
    $null = NULL;
    $stmt->bind_param('isbss', $user_ID, $description, $null,$maplink, $status);
    $stmt->send_long_data(2, $photo_data);
    
    // Execute the statement
    if ($stmt->execute()) {
        session_start();
        $message = array();
        $_SESSION['message'] = $message;
        echo "Post inserted successfully.";
        $message[] = "Post inserted successfully.";
        header('location: like_and_post_test.php');
        exit();
    } else {
        echo "Error inserting post.";
        $message[] = "Error inserting post.";
    }
} else {
    echo "Invalid request.";
    $message[] = "Invalid request.";
}
?>