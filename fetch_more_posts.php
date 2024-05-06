<?php
// Include your database connection file
include 'db_connection.php';

// Fetch additional posts from the database based on the provided offset
if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
    // Convert offset to integer
    $offset = (int)$_GET['offset'];

    // Define the number of posts to fetch
    $limit = 5;

    // Construct the SQL query to fetch additional posts with pagination
    $sql = "SELECT Users.ID AS UserID, Users.FName, Posts.content_id AS PostID, Posts.Link, Posts.Content, Posts.Created_at, COUNT(Like.ContentID) AS NumberOfLikes 
            FROM Posts 
            JOIN Users ON Posts.ID = Users.ID 
            LEFT JOIN `Like` ON Posts.content_id = Like.ContentID 
            WHERE Posts.Status = 'active' 
            GROUP BY Posts.content_id 
            ORDER BY NumberOfLikes DESC 
            LIMIT $limit OFFSET $offset";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if ($result) {
        // Fetch the data and store it in an array
        $posts = array();
        while ($row = mysqli_fetch_assoc($result)) {
            // Check if the user has liked the post
            $liked = false;
            if (isset($_COOKIE['ID'])) {
                $userID = $_COOKIE['ID'];
                $query = "SELECT * FROM `Like` WHERE ContentID = ? AND UserID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $row["PostID"], $userID);
                $stmt->execute();
                $result_likes = $stmt->get_result();
                $liked = $result_likes->num_rows > 0;
            }

            // Build post object
            $post = array(
                'UserID' => $row['UserID'],
                'FName' => $row['FName'],
                'PostID' => $row['PostID'],
                'Link' => $row['Link'],
                'Content' => $row['Content'],
                'Created_at' => $row['Created_at'],
                'NumberOfLikes' => $row['NumberOfLikes'],
                'Liked' => $liked
            );

            // Add post object to posts array
            $posts[] = $post;
        }

        // Return the posts data as JSON
        echo json_encode($posts);
    } else {
        // Return an error message if the query fails
        echo json_encode(array('error' => 'Failed to fetch posts'));
    }
} else {
    // Return an error message if the offset parameter is missing or invalid
    echo json_encode(array('error' => 'Invalid offset parameter'));
}

// Close the database connection
mysqli_close($conn);
?>