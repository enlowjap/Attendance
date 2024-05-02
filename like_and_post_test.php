<?php
session_start();
include 'dbConnect.php'; 

if(isset($_COOKIE['ID'])){
    $user_ID = $_COOKIE['ID'];
 }else{
    $user_ID = '';
    header('location:Login.php');}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .message{
    position: fixed;
    top:0;
    margin:0 auto;
    background-color: white;
    padding:2rem;
    display: flex;
    align-items: center;
    gap:1rem;
    justify-content: space-between;
    animation: hideMessage 3.5s forwards;
 }

 .message.hide {
    display: none;
}
 
 .message.form{
    max-width: 1200px;
    margin: 0 auto;
    background-color: var(--white);
    top: 2rem;
    border-radius: .5rem;
 }

 @keyframes hideMessage {
    0% { opacity: 1; }
    90% { opacity: 1; }
    100% { opacity: 0; display: none; }
}
 
 .message span{
    font-size: 2rem;
    color:var(--black);
 }
 
 .message i{
    font-size: 2.5rem;
    color:var(--red);
    cursor: pointer;
    transition: .2s linear;
 }
 
 .message i:hover{
    transform: rotate(90deg);
 }
    </style>
</head>
<body>
<a href="logout.php">Logout</a>
<?php 
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
            if(is_array($message)){
                foreach($message as $msg){
                echo '
                <div class="message">
                    <span>'.$msg.'</span>
                    <i class="fas fa-times" onclick="removeMessage(this.parentElement);"></i>
                </div>
                ';
                }
            } else {
                echo '
                <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="removeMessage(this.parentElement);"></i>
                </div>
                ';
            }
            unset($_SESSION['message']);
        }
        ?>

        <script>
            function removeMessage(element) 
                {
                element.classList.add("hide");
            }
        </script>
    <h1>Create Post</h1>
    <div>
        <form action="insertpost.php" method="post" enctype="multipart/form-data">
        <p>Post Description</p>
        <textarea name="description" id="" cols="30" rows="8"></textarea>
        <p>Image</p>
        <input type="file" name="photo" accept="image/*">
        <input type="submit">
        </form>
    </div>


    <h1>Like a Post </h1>
    <div>
    <table>
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Post ID</th>
        <th>Description</th>
        <th>Image</th>
        <th>Date posted</th>
        <th>CountOfLikes</th>
    </tr>
    <?php
        // Fetching data from the database
        $sql = "SELECT Users.ID AS UserID, Users.FName, Posts.content_id AS PostID, Posts.Content, Posts.Created_at, COUNT(Like.ContentID) AS NumberOfLikes 
                FROM Posts 
                JOIN Users ON Posts.ID = Users.ID 
                LEFT JOIN `Like` ON Posts.content_id = Like.ContentID 
                WHERE Posts.Status = 'active' 
                GROUP BY Posts.content_id 
                ORDER BY NumberOfLikes DESC";
        $result = mysqli_query($conn, $sql);

        // Check if there are any results
        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
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
                
                echo "<tr>";
                echo "<td>" . $row["UserID"] . "</td>";
                echo "<td>" . $row["FName"] . "</td>";
                echo "<td>" . $row["PostID"] . "</td>";
                echo "<td>" . $row["Content"] . "</td>";
                echo "<td><img src='image_display.php?id=" . $row["PostID"] . "' style='max-width: 100px; max-height: 100px;'></td>";
                echo "<td>" . $row["Created_at"] . "</td>";
                echo "<td>" . $row["NumberOfLikes"] . "</td>";
                echo "<td><div id='likeButton-" . $row["PostID"] . "'>";
                if ($liked) {
                    echo "<button type='button' onclick='toggleLike(" . $row["PostID"] . ")'>Liked</button>";
                } else {
                    echo "<button type='button' onclick='toggleLike(" . $row["PostID"] . ")'>Like</button>";
                }
                echo "</div></td>";
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='6'>No posts found</td></tr>";
        }
    ?>
    </table>
            <script>
                function toggleLike(postID) {
                    var likeButton = document.getElementById('likeButton-' + postID);
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            likeButton.innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("POST", "like_toggle.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("postID=" + postID);
                }
            </script>
    </div>
</body>
</html>