<?php
session_start();

include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"]) && isset($_POST["comment_content"])) {
    $post_id = $_POST["post_id"];
    $comment_content = $_POST["comment_content"];
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

    // Insert the comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $user_id, $comment_content);

    if ($stmt->execute()) {
        echo "Comment posted successfully.";
    } else {
        echo "Error posting comment: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>
