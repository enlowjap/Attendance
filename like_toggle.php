<?php
// Include database connection
include 'dbConnect.php';

// Get postID from the AJAX request
$postID = isset($_POST['postID']) ? $_POST['postID'] : '';

// Get UserID from cookie
$userID = isset($_COOKIE['ID']) ? $_COOKIE['ID'] : '';

// Check if the user has already liked the post
$query = "SELECT * FROM `Like` WHERE ContentID = ? AND UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $postID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User has already liked the post, remove like
    $deleteQuery = "DELETE FROM `Like` WHERE ContentID = ? AND UserID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $postID, $userID);
    $deleteStmt->execute();
    echo "<button type='button' onclick='toggleLike(" . $postID . ")'>Like</button>";
} else {
    // User has not liked the post, insert like
    $insertQuery = "INSERT INTO `Like` (ContentID, UserID) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ii", $postID, $userID);
    $insertStmt->execute();
    echo "<button type='button' onclick='toggleLike(" . $postID . ")'>Liked</button>";
}

$stmt->close();
$conn->close();
?>