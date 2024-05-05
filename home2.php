<?php
session_start();

// Set the time zone to Asia/Manila
date_default_timezone_set('Asia/Manila');

include 'dbConnect.php';

$errors = [];

// Check if file is uploaded successfully
if (isset($_FILES["postImage"]) && $_FILES["postImage"]["error"] == 0) {
    $postImage = file_get_contents($_FILES["postImage"]["tmp_name"]);
    $postImageBase64 = base64_encode($postImage);
    // Now you can use $postImageBase64 in your SQL query or save it to a directory
}



// Fetch user data
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT FName, LName, profile_image FROM users WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();      

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fname = $row["FName"];
            $lname = $row["LName"];
            $imageBase64 = $row["profile_image"];
        } else {
            $errors[] = "User not found";
        }
    } else {
        $errors[] = "Error: " . $conn->error;
    }
} else {
    $errors[] = "User ID not set in session";
}

// Display errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["postContent"])) {
        $postContent = $_POST["postContent"];
        $postLink = isset($_POST["postLink"]) ? $_POST["postLink"] : ""; // Retrieve post link data
        $currentDateTime = date("Y-m-d H:i:s");

        try {
          // Handle file upload if an image is selected
        if (isset($_FILES["postImage"]) && $_FILES["postImage"]["error"] == 0) {
            $postImage = file_get_contents($_FILES["postImage"]["tmp_name"]);
            $postImageBase64 = base64_encode($postImage);

            $stmt = $conn->prepare("INSERT INTO posts (ID, content, image, link, created_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user_id, $postContent, $postImageBase64, $postLink, $currentDateTime);
            $stmt->execute();
        } else {
            // No image provided, insert data without image
            $stmt = $conn->prepare("INSERT INTO posts (ID, content, link, created_at) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $postContent, $postLink, $currentDateTime);
            $stmt->execute();
        }

            if ($stmt->affected_rows > 0) {
                echo "Post saved successfully.";

                // Redirect back to the original page (home2.php) after form submission
    header("Location: home2.php");
    exit(); // Ensure no further code execution after the redirect
            } else {
                $errors[] = "Failed to save post.";
            }
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// Fetch existing posts from the database
$posts = [];
$sql = "SELECT p.ID as post_id, p.content, p.image, p.link, p.created_at, u.FName, u.LName, u.profile_image
        FROM posts p
        JOIN users u ON p.ID = u.ID
        ORDER BY p.created_at DESC"; // Assuming your posts table has columns for user ID, content, image, link, and creation timestamp
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
} else {
    $errors[] = "No posts found.";
}

// Display errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
} else {
    // // Display posts
    // foreach ($posts as $post) {
    //     echo "<div class='post-item'>";
    //     echo "<img src='data:image/jpeg;base64," . $post['image'] . "' alt='Post Image'>";
    //     echo "<p>{$post['content']}</p>";
    //     echo "<p><strong>{$post['FName']} {$post['LName']}</strong></p>";
    //     echo "<a href='{$post['link']}' target='_blank'>{$post['link']}</a>";
    //     echo "<p>{$post['created_at']}</p>";
    //     echo "<form action='comment_handler.php' method='POST'>";
    //     echo "<input type='hidden' name='post_id' value='{$post['post_id']}'>";
    //     echo "<textarea name='comment_content' placeholder='Write your comment here'></textarea>";
    //     echo "<button type='submit'>Comment</button>";
    //     echo "</form>";
    //     echo "</div>";
    // }
    
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Posting Function</title>

<link rel="stylesheet" href="home.css">

<style>


    body {
        font-family: Arial, sans-serif, roboto;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: rgb(36, 37, 38);
        
    }
   /* Navbar styles */
   .navbar {
        position: fixed;
        top: 0;
        height: 40px;
        width: 100%;
        background-color: rgb(51, 51, 51);
        padding: 10px 20px; /* Adjust padding as needed */
        box-sizing: border-box; /* Include padding in width */
        z-index: 1000; /* Ensure the navbar is above other content */
        text-align: center; /* Center the links */
    }

    .navbar a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
    }

    /* Sample styles for content */
    .content {
        padding: 20px;
        margin-top: 80px; /* Ensure content is below navbar when scrolling */
    }

    /* Style for sticky navbar */
    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
        animation: slide-down 0.5s ease;
    }

    @keyframes slide-down {
        0% {
            transform: translateY(-100%);
        }
        100% {
            transform: translateY(0);
        }
    }
     /* Search box styles */
    .search-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 50px; /* Add margin top to create space between navbar and search box */
    }


    .search-box {
        display: flex;
        align-items: center;
        width: 100%;
        max-width: 500px; /* Adjust maximum width as needed */
        border: 0px solid #ccc;
        border-radius: 5px;
        overflow: hidden;
    }

    .search-box input[type="text"] {
        flex: 1;
        padding: 8px;
        border: none;
        outline: none;
    }

    .search-box button {
        padding: 8px;
        background-color: rgb(58, 59, 60);
        color: white;
        border: none;
        cursor: pointer;
       
    }

    .search-box button:hover {
        background-color: rgb(24, 25, 26);
    }
    @media (max-width: 768px) {
    .trending-location-panel,
    .my-routes-panel {
        display: none;
    }
}

    /* Styling for the Trending Location Panel */
    .trending-location-panel {
        position: fixed;
        left: 0;
        top: 40px; /* Adjust as needed based on your navbar height */
        width: 200px; /* Adjust width as needed */
        background-color: rgb(58, 59, 60);
        padding: 10px;
        box-sizing: border-box;
        color: white;
        border-radius: 0 8px 8px 0; /* Rounded corners on the right side */
        }
        .trending-location-panel {
        position: fixed;
        left: 0px; /* Adjust the left position */
        top: calc(80px + 20px); /* Align with the top of the post panel */
        width: 200px; /* Adjust width as needed */
        background-color: rgb(58, 59, 60);
        padding: 10px;
        box-sizing: border-box;
        color: white;
        border-radius: 8px; /* Rounded corners */
        z-index: 100; /* Ensure it's above other content */
    }

    .trending-location-panel h3, .my-routes-panel h3 {
        margin-bottom: 10px;
    }

    .trending-location-panel ul, .my-routes-panel ul {
        list-style-type: none;
        padding: 0;
    }

    .trending-location-panel  ul li, .my-routes-panel ul li {
        margin-bottom: 5px;
    }

    .trending-location-panel ul li a, .my-routes-panel ul li a {
        color: white;
        text-decoration: none;
    }

    .trending-location-panel ul li a:hover, .my-routes-panel  ul li a:hover {
        text-decoration: underline;
    }
    /* Styling for the My Routes Panel */
    .my-routes-panel {
        position: fixed;
        right: 0px; /* Adjust the right position */
        top: calc(80px + 20px); /* Align with the top of the post panel */
        width: 200px; /* Adjust width as needed */
        background-color: rgb(58, 59, 60);
        padding: 10px;
        box-sizing: border-box;
        color: white;
        border-radius: 8px; /* Rounded corners */
        z-index: 100; /* Ensure it's above other content */
    }

    .post-panel {
        border-radius: 8px;
        padding: 12px;
        width: 500px;
        margin: 20px auto;
        box-sizing: border-box; /* Include padding in width */
        background-color: rgb(58, 59, 60);
    }
    .post-panel textarea {
        width: 100%;
        height: 120px;
        resize: none;
        margin-bottom: 10px;
        background-color: rgb(58, 59, 60);
        color: #fff;
        font-family: Arial, sans-serif;
        border: 1px solid rgb(78, 79, 80);
    }
    .post-panel input[type="file"]{
        margin-bottom: 10px;
        width: calc(100% - 70px); /* Adjust width to accommodate the button */
        cursor: pointer;
        color: #fff;
    }
     /* Style for file input */
     .file-input {
        display: block; /* Display as a block element */
        margin-top: 10px; /* Add margin for spacing */
        border: 1px solid rgb(78, 79, 80);
    }

    .file-input label {
        background-color: rgb(36, 37, 38); /* Button background color */
        color: white; /* Button text color */
        padding: 8px 12px; /* Button padding */
        border-radius: 4px; /* Button border radius */
        cursor: pointer; /* Change cursor on hover */
        display: inline-block; /* Display as inline-block for button appearance */
    }

    .file-input label:hover {
        background-color: rgb(78, 79, 80); /* Button background color on hover */
    }

    /* Hide default file input styling */
    .file-input input[type="file"] {
        display: none; /* Hide the file input */
    }

    /* Style the file name display */
    .file-name {
        margin-top: 5px; /* Add margin for spacing */
        color: white; /* Text color for file name */
    }
    #postLink {
    height: 32px; /* Adjust the height as needed */

    }
    .post-panel input[type="text"] {
        margin-bottom: 10px;
        width: calc(100% - 5px); /* Adjust width to accommodate the button */
        background-color: rgb(58, 59, 60);
        border: none;
        color: #fff;
        border: 1px solid rgb(78, 79, 80);
    }
    .post-panel button {
        display: block;
        width: 100%;
        padding: 8px;
        background-color: rgb(36, 37, 38);
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    .post-panel button:hover {
        background-color: rgb(78, 79, 80);
    }
    .post-list {
        list-style-type: none;
        padding: 0;
        display: flex;
        flex-direction: column; /* Stack items vertically */
        align-items: center; /* Center items horizontally */
        color: #fff; 
        
    }
    .post-item {
        border: none;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 10px;
        width: 100%; /* Expand to full width */
        max-width: 500px; /* Limit to 500px width */
        box-sizing: border-box; /* Include padding in width */
        text-align: left; /* Align text to the left */
        background-color: rgb(58, 59, 60);
    }
    .post-info {
    margin-bottom: 10px;
    text-align: left; /* Center the name and date/time */
    }
    .date-label {
        color: #A5A8AC;
        font-size: 12px;
        margin-top: 2px;
    }
    .name-label {
        color: white;
        font-size: 14px;
        margin-bottom: 0px;
    }
    .post-item img {
        max-width: 100%;
        height: 500px; /* Adjusted height for better symmetry */
        width: 100%; /* Fill the container */
        object-fit: cover;
        margin-bottom: 10px;
        cursor: pointer; /* Add cursor pointer to indicate clickability */
        
    }

    .post-item .post-link {
        font-size: 14px;
        margin-top: 10px;
        color:  rgb( 82, 148, 223);
        display: inline-block;
        max-width: calc(100% - 20px); /* Adjust maximum width */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .post-item .action-panel {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
        background-color: rgb(58, 59, 60); /* Background color for the action panel */
        padding: 8px; /* Padding for the action panel */
        border-radius: 5px; /* Rounded corners for the action panel */
    }

    .post-item .action-btn {
        flex: 1; /* Distribute available space equally among action buttons */
        margin-right: 5px; /* Add some spacing between buttons */
        padding: 8px; /* Adjust padding for the action buttons */
        background-color: rgb(58, 59, 60);
        color: #fff;
        border: 0px solid #ccc;
        cursor: pointer;
        transition: box-shadow 0.3s ease, background-color 0.3s ease; /* Add transition for smooth hover effect */
    }

    .post-item .action-btn:hover {
        background-color: rgb(78, 79, 80); /* Change background color on hover */
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Add box shadow on hover */
    }
    
    /* Add these styles to your existing CSS */
   
    .avatar-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #fff;
        display: inline-block;
        vertical-align: middle; /* Align the circle vertically */
        margin-right: 0px;
        overflow: hidden; /* Ensure the image stays within the circle */
        object-fit: cover; /* Scale the image to cover the entire circle */
    }
    .name-label {
        display: inline-block;
        color: #fff;
        font-size: 14px;
        vertical-align: middle; /* Align the label vertically */
        padding-right: 30px;
       margin-top: 0px;
    }
    .avatar-circle img{
        width: 100%;
        height: 100%;

    }

    /* Modal Styling */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 9999; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        height: auto;
    }

    .like-label {
    position: absolute;
    top: 10px;
    left: 10px;
    color: white;
    font-size: 14px;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 4px 8px;
    border-radius: 4px;
}


    /* Close Button */
    .close {
        color: #aaa;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 28px;
        font-weight: bold;
        padding: 10px;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }
    .action-panel {
    position: relative; /* Make sure the parent container is positioned */
}

.comment-form {
    position: absolute;
    top: 100%; /* Position the comment form below the comment button */
    left: 0;
    width: 95%;
    padding: 10px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    display: none; /* Initially hide the comment form */
    display: flex; /* Use flexbox to align items */
    align-items: center; /* Center items vertically */
    justify-content: space-between; /* Space items evenly */
}

.comment-form input[type='hidden'],
.comment-form textarea {
    flex: 1; /* Take up remaining space */
    padding: 5px;
    margin-bottom: 5px;
    box-sizing: border-box; /* Include padding in width calculation */
}

.comment-form textarea {
    width: 335px;
    resize: none; /* Allow vertical resizing */
}

.comment-form button {
    padding: 5px 10px;
    margin-left: 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    position: absolute;
    top: 20%; /* Position the comment form below the comment button */
   
}

.comment-form button:hover {
    background-color: #0056b3;
}

    
</style>
</head>
<body>
         <!-- Navbar -->
    <nav id="navbar" class="navbar">
        <a href="home2.php">Home</a>
        <a href="UserProfile.php">Profile</a>
        <a href="Login.php">Logout</a>
       <!-- <a href="#Discussion Board">Services</a>-->
        
    </nav>

        <div class="search-container">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search posts...">
                    <button type="button" onclick="searchPosts()">Search</button>
                </div>
            </div>

             <!-- Trending Location Panel -->
            <div class="trending-location-panel">
                <h3>Trending Location</h3>
                <hr>
                <ul>
                    <li><a href="#">- Location 1</a></li>
                    <li><a href="#">- Location 2</a></li>
                    <li><a href="#">- Location 3</a></li>
                    <!-- Add more locations as needed -->
                </ul>
            </div>

             <!-- Trending Location Panel -->
             <div class="my-routes-panel">
                <h3>My Routes</h3>
                <hr>
                <ul>
                    <li><a href="#">- Route 1</a></li>
                    <li><a href="#">- Route 2</a></li>
                    <li><a href="#">- Route 3</a></li>
                    <!-- Add more locations as needed -->
                </ul>
            </div>

            <div class="post-panel">
                <form method="POST" action="" id="postForm" enctype="multipart/form-data">
                <textarea id="postContent" name="postContent" placeholder="Write your post here..."></textarea>
                <!-- File input with custom styling -->
                <div class="file-input">
                    <label for="postImage">Choose Image</label>
                    <input type="file" id="postImage" name="postImage" accept="image/*">
                </div>
                <br>
                <input type="text" id="postLink" name="postLink" placeholder="Paste link here (optional)">
                <button type="submit" form="postForm">Post</button>

            </form>

            </div>

            <ul class="post-list" id="postList">
    <!-- Loop through posts and create post items -->
    <?php foreach ($posts as $post): ?>
        <li class="post-item">
            <div class="post-info">
                <div class="avatar-circle">
                    <!-- Profile picture will be added here -->
                    <img src="<?php echo !empty($imageBase64) ? "data:image/jpeg;base64," . $imageBase64 : "default_profile.jpg"; ?>" alt="Profile Picture">
                </div>
                <p class="name-label"><?= $post['FName'] ?> <?= $post['LName'] ?></p>
                <p class="date-label"><?= date('M d, Y h:i:s A', strtotime($post['created_at'])) ?></p>
            </div>
            <div class="post-content">
                <p><?= $post['content'] ?></p>
                <a href="<?= $post['link'] ?>" target="_blank" class="post-link"><?= $post['link'] ?></a>
            </div>
            <img src="data:image/jpeg;base64,<?= $post['image'] ?>" alt="Post Image">
            
            <!-- Action Panel -->
            <div class="action-panel">
                <!-- Like button with label -->
                <div class="like-label">1 Like</div>
                <button class="action-btn" id="likeBtn_<?= $post['post_id'] ?>" onclick="likePost(<?= $post['post_id'] ?>)">Like</button>
                <!-- Comment button -->
                <button class="action-btn" onclick="toggleCommentBox(this)">Comment</button>
                <!-- Comment form -->
                <div class="comment-form" style="display:none;">
                    <form action='comment_handler.php' method='POST'>
                        <input type='hidden' name='post_id' value='<?= $post['post_id'] ?>'>
                        <div class="comment-inputs">
                            <textarea name='comment_content' placeholder='Write your comment here'></textarea>
                            <button type='submit' class="action-btn">Post Comment</button>
                        </div>
                    </form>
                </div>
                <button class="action-btn">Report</button>
            </div>
        </li>
    <?php endforeach; ?>
</ul>


<script>
   function toggleCommentBox(button) {
    var commentForm = button.nextElementSibling;
    if (commentForm.style.display === "none") {
        commentForm.style.display = "block";
    } else {
        commentForm.style.display = "none";
    }
}

</script>





            <!-- The Modal -->
            <div id="imageModal" class="modal">
                <span class="close" onclick="closeModal()">&times;</span>
                <img class="modal-content" id="fullImage">
            </div>

            <script>
        // Get the modal
        var modal = document.getElementById('imageModal');

        // Get the image and set it inside the modal
        var img = document.getElementById('fullImage');
        var modalImg = document.getElementById('fullImage');

        // Function to display the modal with the clicked image
        function displayModal(imageSrc) {
            modal.style.display = 'block';
            modalImg.src = imageSrc;
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Event listener to close the modal when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        function postContent() {
    // Get the post content from the textarea
    var postContent = document.getElementById('postContent').value;
    var postImage = document.getElementById('postImage').files[0];
    var postLink = document.getElementById('postLink').value;

    // Check if the post content is not empty
    if (postContent.trim() !== '' || postImage || postLink.trim() !== '') {
        // Create a new post item
        var postItem = document.createElement('li');
        postItem.className = 'post-item';
        // Generate a unique ID for the post item
        var postId = 'post_' + Date.now(); // Example: post_1648843762671
        postItem.id = postId;

        // Get profile picture and name values from PHP
        var profilePicUrl = '<?php echo !empty($imageBase64) ? "data:image/jpeg;base64," . $imageBase64 : "default_profile.jpg"; ?>';
        var fullName = '<?php echo $fname . " " . $lname; ?>';
        var userID = <?php echo $user_id; ?>; // Assuming $user_id is set in your PHP code

        // Create a circle element for the avatar
        var avatarCircle = document.createElement('div');
        avatarCircle.className = 'avatar-circle';
        postItem.appendChild(avatarCircle);
        
         // Create a label for the name
         var nameLabel = document.createElement('p');
        nameLabel.textContent = fullName;
        nameLabel.className = 'name-label';
        postItem.appendChild(nameLabel);

        // Create a paragraph for the post text and add it to the post item
        var textParagraph = document.createElement('p');
        textParagraph.textContent = postContent;
        postItem.appendChild(textParagraph);

        // Create an image element for the profile picture
        var avatarImg = document.createElement('img');
        avatarImg.src = profilePicUrl;
        avatarImg.alt = 'Profile Picture';
        avatarImg.style.width = '100%'; // Ensure the image fills the circle
        avatarImg.style.height = '100%'; // Ensure the image fills the circle
        avatarCircle.appendChild(avatarImg);

                // Upload the image using AJAX if it's selected
                if (postImage) {
                    var formData = new FormData();
                    formData.append('userID', userID);
                    formData.append('postContent', postContent);
                    formData.append('postImage', postImage);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true); // Adjust the URL to match your PHP script
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log(xhr.responseText);
                        }
                    };
                    xhr.send(formData); // Make sure formData contains the correct data
                }

                // Create a link element if a link is provided
                if (postLink.trim() !== '') {
                    var linkElement = document.createElement('a');
                    linkElement.href = postLink.trim();
                    linkElement.textContent = 'Link: ' + postLink.trim();
                    linkElement.className = 'post-link'; // Add a class for styling
                    linkElement.target = '_blank';
                    postItem.appendChild(linkElement);
                }

                // Create an image element for the uploaded image and add it to the post item
                if (postImage) {
                    var imageElement = document.createElement('img');
                    imageElement.src = URL.createObjectURL(postImage);
                    imageElement.alt = 'Uploaded Image';
                    imageElement.onclick = function() {
                        displayModal(this.src); // Display the full image in the modal
                    };
                    postItem.appendChild(imageElement);
                }

                // Create an action panel for Like, Comment, and Copy Link buttons
                var actionPanel = document.createElement('div');
                actionPanel.className = 'action-panel';

                // Create Like button
                var likeButton = document.createElement('button');
                likeButton.textContent = 'Like';
                likeButton.className = 'action-btn';
                likeButton.onclick = function() {
                    likePost(postId); // Pass the postId to the likePost function
                };
                actionPanel.appendChild(likeButton);

                // Create Comment button
                var commentButton = document.createElement('button');
                commentButton.textContent = 'Comment';
                commentButton.className = 'action-btn';
                actionPanel.appendChild(commentButton);

                // Create Copy Link button
                var copyLinkButton = document.createElement('button');
                copyLinkButton.textContent = 'Copy Link';
                copyLinkButton.className = 'action-btn';
                actionPanel.appendChild(copyLinkButton);

                // Add action panel to the post item
                postItem.appendChild(actionPanel);

                // Get the post list
                var postList = document.getElementById('postList');

                // Insert the new post item at the beginning of the post list
                postList.insertBefore(postItem, postList.firstChild);

                // Clear the textarea, image input, and link input
                document.getElementById('postContent').value = '';
                document.getElementById('postImage').value = ''; // Clear the file input
                document.getElementById('postLink').value = '';
            } else {
                alert('Please enter some content, upload an image, or provide a link for your post.');
            }
        }

        function likePost(postId) {
            var postItem = document.getElementById(postId);
            if (postItem) {
                var likeButton = postItem.querySelector('.like-btn');
                if (likeButton) {
                    likeButton.textContent = 'Liked';
                    likeButton.disabled = true;
                }
            }
        }
    </script>

    <script>
        function likePost(postId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'likePost.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Update the button text and disable it
                var likeButton = document.getElementById('likeBtn_' + postId);
                if (likeButton) {
                    likeButton.textContent = 'Liked';
                    likeButton.disabled = true;
                }
            } else {
                alert(response.message); // Display error message if the post is already liked
            }
        }
    };
    xhr.send('action=like&postId=' + postId);
}

    </script>
<script>
        window.onscroll = function() { stickyNavbar() };

        var navbar = document.getElementById('navbar');
        var sticky = navbar.offsetTop;

        function stickyNavbar() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        }

        // Function to display the selected file name
        function displayFileName() {
            var fileInput = document.getElementById('postImage');
            var fileNameDisplay = document.getElementById('fileName');
            
            if (fileInput.files.length > 0) {
                // Get the first file from the list of selected files
                var fileName = fileInput.files[0].name;
                fileNameDisplay.textContent = fileName;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        }

    </script>

    

</body>
</html>
