<?php
session_start();

include 'dbConnect.php';

$errors = [];

// Update profile image if a new image is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    // Validate file upload
    $image = file_get_contents($_FILES["image"]["tmp_name"]);
    $imageBase64 = base64_encode($image);

    try {
        $user_id = $_SESSION['user_id']; // Assuming user is logged in
        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE ID = ?");
        $stmt->bind_param("si", $imageBase64, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Image updated successfully
            echo "Profile image updated successfully.";
        } else {
            $errors[] = "Failed to update profile image.";
        }
    } catch (Exception $e) {
        $errors[] = "Database error: " . $e->getMessage();
    }
}

// Update bio and interests
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bio']) && isset($_POST['interests'])) {
    $bio = $_POST['bio'] ?? '';
    $interests = $_POST['interests'] ?? '';

    try {
        $user_id = $_SESSION['user_id']; // Assuming user is logged in
        $stmt = $conn->prepare("UPDATE users SET bio = ?, interests = ? WHERE ID = ?");
        $stmt->bind_param("ssi", $bio, $interests, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Bio and interests updated successfully
            echo "Bio and interests updated successfully.";
        } else {
            $errors[] = "Failed to update bio and interests.";
        }
    } catch (Exception $e) {
        $errors[] = "Database error: " . $e->getMessage();
    }
}

// Fetch user data
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT FName, LName, profile_image, bio, interests FROM users WHERE ID = $user_id";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Fetching user data
            $row = $result->fetch_assoc();
            $fname = $row["FName"];
            $lname = $row["LName"];
            $imageBase64 = $row["profile_image"]; // Retrieve profile image from database
            $bio = $row["bio"];
            $interests = $row["interests"];
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
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/UserProfile.css">
    
</head>
<body>

<?php
    include 'homenavbar.php'; 
?>



<div class="panel">
    <div class="circle" id="profile-circle" style="background-image: url(data:image/jpeg;base64,<?php echo $imageBase64; ?>);">
        <div class="user-info">
            <h2 class="user-name"><?php echo $fname . " " . $lname; ?></h2>
            <p id="interests">Interests: <?php echo $interests; ?></p>
            <p id="bio">Bio: <?php echo $bio;  ?> </p>
            <button class="edit-btn" onclick="toggleEdit()">Edit</button>

             <!-- 
                <hr/>
            <div class="actions">
                <div class="left-action">Post<p>0</p></div>
                <div class="center-action">Replies<p>0</p></div>
                <div class="right-action">Reaction Score<p>0</p></div>
            </div> -->
            <form method="post" enctype="multipart/form-data">
                <label class="upload-btn">
                    <input type="file" name="image" accept="image/*" onchange="this.form.submit()">
                    Upload Image
                </label>
            </form>
        </div>
    </div>
</div>



    
<script>

function toggleEdit() {
    var interests = document.getElementById("interests");
    var bio = document.getElementById("bio");
    var editBtn = document.querySelector(".edit-btn");

    if (editBtn.innerText === "Edit") {
        // Extract data from the labels
        var interestsValue = interests.innerText.split(": ")[1] || '';
        var bioValue = bio.innerText.split(": ")[1] || '';
        
        // Change text to input fields
        interests.innerHTML = '<input type="text" id="interestsInput" placeholder="Interests" value="' + interestsValue + '">';
        bio.innerHTML = '<textarea id="bioTextarea" maxlength="100" placeholder="Bio">' + bioValue + '</textarea>';
        // Change button text to "Save"
        editBtn.innerText = "Save";
    } else {
        // Get the values from input fields
        var interestsValue = document.getElementById("interestsInput").value;
        var bioValue = document.getElementById("bioTextarea").value;

        // Send AJAX request to update the database
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Handle success
                    console.log("Data saved successfully.");
                    // Update the text with input field values
                    interests.innerHTML = "Interests: " + interestsValue;
                    bio.innerHTML = "Bio: " + bioValue;
                    // Change button text back to "Edit"
                    editBtn.innerText = "Edit";
                } else {
                    // Handle error
                    console.error("Error: " + xhr.responseText);
                }
            }
        };
        xhr.send("interests=" + encodeURIComponent(interestsValue) + "&bio=" + encodeURIComponent(bioValue));
    }
}



</script>



  


<div class="second-panel">
    <div class="post">
        <div class="circle23"></div>
            <div class = "Share-Route">  
            <button id="shareRouteBtn">Share Route</button>
            <div id="popupContainer" class="popup-container">
                <div class="popup-content">
                    <span class="close-btn" onclick="closePopup()">×</span>
                    <h3>Create Route</h3>
                    <!-- Your route creation form or content goes here -->
                   
                        <label for="routeName">Route Name</label>
                        <input type="text" id="routeName" placeholder="Write your route name">
                   
                        <label for="startingPoint">Loop</label>
                        <input type="text" id="startingPoint" placeholder="Loop">
                   
                        <!--<label for="Destination">End Point</label>
                        <input type="text" id="endPoint" placeholder="End point"> -->
                   
                        <label for="Description">Description</label>
                        <textarea name="" id="" cols="30" rows="10" placeholder="Add a description..."></textarea>                   
                         <br/>
                   
                    <!-- Add more inputs as needed -->
                    <button class="create-btn">Next</button>
                </div>
            </div>        
        </div>
    </div>
</div>

    <script>
        // Function to open the popup container
        function openPopup() {
            document.getElementById("popupContainer").style.display = "block";
        }

        // Function to close the popup container
        function closePopup() {
            document.getElementById("popupContainer").style.display = "none";
        }

        // Event listener for the Share Route button
        document.getElementById("shareRouteBtn").addEventListener("click", function() {
            openPopup();
        });
    </script>



<div class="message-text">
    There are no posts on your profile yet.
</div>

</body>
</html>
