<?php
session_start();
include 'dbConnect.php'; // Assuming this file contains your database connection logic

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["postId"]) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST["postId"];

    // Check if the user has already liked the post
    $sql_check_like = "SELECT * FROM post_likes WHERE content_id = ? AND user_id = ?";
    $stmt_check_like = $conn->prepare($sql_check_like);
    $stmt_check_like->bind_param("ii", $post_id, $user_id);
    $stmt_check_like->execute();
    $result_check_like = $stmt_check_like->get_result();

    if ($result_check_like && $result_check_like->num_rows == 0) {
        // User hasn't liked the post, so insert a new like
        $sql_insert_like = "INSERT INTO post_likes (content_id, user_id, liked, like_count) VALUES (?, ?, TRUE, 1)";
        $stmt_insert_like = $conn->prepare($sql_insert_like);
        $stmt_insert_like->bind_param("ii", $post_id, $user_id);
        
        if ($stmt_insert_like->execute()) {
            // Update the like count in the posts table
            $sql_update_like_count = "UPDATE posts SET like_count = like_count + 1 WHERE ID = ?";
            $stmt_update_like_count = $conn->prepare($sql_update_like_count);
            $stmt_update_like_count->bind_param("i", $post_id);
            
            if ($stmt_update_like_count->execute()) {
                echo "success";
            } else {
                echo "Error updating like count: " . $conn->error;
            }
        } else {
            echo "Error adding like: " . $conn->error;
        }
    } else {
        echo "already_liked";
    }
} else {
    echo "Invalid request.";
}
?>
