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
    <title>Homepage</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/HOMEs.css">
</head>
<body>
    <?php
    include 'homenavbar.php'; 
    ?>

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

    <div class="maincont">
        <div class="cpostcont">
            <h1>Create Route</h1>
            <div class="c">
                <form action="insertpost.php" method="post" enctype="multipart/form-data">
                <p>Post Description</p>
                <textarea name="description" id="" cols="30" rows="8" required></textarea>
                <p>Image</p>
                <input type="file" id="fileInput" name="photo" accept="image/*" required>
                <img id="imagePreview" src="#" alt="" class="imgpreview">
                <script>
                    // Function to handle file input change event
                    document.getElementById('fileInput').addEventListener('change', function(event) {
                        var file = event.target.files[0]; // Get the selected file
                        var imagePreview = document.getElementById('imagePreview');

                        // Check if a file is selected
                        if (file) {
                            var reader = new FileReader(); // Create a FileReader object

                            // Set up the FileReader onload event
                            reader.onload = function(event) {
                                imagePreview.src = event.target.result; // Set the image source to the FileReader result
                            };

                            // Read the file as a data URL
                            reader.readAsDataURL(file);
                        } else {
                            // If no file is selected, reset the image source
                            imagePreview.src = "#";
                        }
                    });
                </script>
                
                <div class="mapbttn">
                    <div><button type="button" id="routeBtn">Google Route Creator</button>
                    <button type="button" id="getUrlBtn">Get the URL</button></div>
                    
                    <input type="text" id="urlTextbox" placeholder="Map URL" name="link" readonly>
                </div>

                <script>
                    // Function to open Google Maps in a new tab
                    function openGoogleMaps() {
                        window.open('https://www.google.com/maps/', '_blank');
                    }

                    // Function to paste the copied link into the textbox
                    function pasteUrlFromClipboard() {
                        navigator.clipboard.readText().then(function(clipboardText) {
                            document.getElementById('urlTextbox').value = clipboardText;
                        });
                    }

                    // Event listener for the "Route" button click
                    document.getElementById('routeBtn').addEventListener('click', function() {
                        openGoogleMaps();
                    });

                    // Event listener for the "Get the URL" button click
                    document.getElementById('getUrlBtn').addEventListener('click', function() {
                        pasteUrlFromClipboard();
                    });
                </script>
                <input type="submit">
                </form>
            </div>
        </div>

        <div class="post">
            <h1>Route Post</h1>
            <div class="postcontent">
            <?php
                // Fetching data from the database
                $sql = "SELECT Users.ID AS UserID, Users.FName, Posts.content_id AS PostID,Posts.Link, Posts.Content, Posts.Created_at, COUNT(Like.ContentID) AS NumberOfLikes 
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
                        
                        echo '<div class="contentp">';
                        echo '<div class="userprofile">';

                        
                        // get DP of user
                        $defaultImagePath = "../picture/user.png";
                        $userdpID = $row["UserID"];
                        $sql = "SELECT Profile_image FROM Users WHERE ID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $userdpID);
                        $stmt->execute();
                        $result_dp = $stmt->get_result();
                        $row_dp = $result_dp->fetch_assoc();
                        $imageData = $row_dp["Profile_image"];

                        // Set the image source based on whether image data is fetched or not
                        $imageSource = ($imageData !== null) ? $imageData : $defaultImagePath;
                        echo '<img src="' . $imageSource . '" style="width: 3rem; height: 3rem; object-fit: contain; border-radius: 50%;">';

                        echo '<h2>' . $row["FName"] . '</h2>';
                        echo '<p>' . $row["Created_at"] . '</p>';
                        echo '</div>';

                        echo '<div class="pcontent">';
                        echo '<p>' . $row["Content"] . '</p>';
                        echo '<img src="image_display.php?id=' . $row["PostID"] . '" style="mwidth: 30rem; height: 25rem; border-radius: 3%;">';
                        echo '<div class="link_container">';
                        echo '<a href="' . $row["Link"] . '" target="_blank">' . $row["Link"] . '</a>';
                        echo '</div>';

                        echo '<div class="likes">';
                        echo '<div id="likeButton-' . $row["PostID"] . '">';
                        echo '<p class="countL">' . $row["NumberOfLikes"] . '</p>';
                        if ($liked) {
                            echo '<button type="button" class="likebutton" onclick="toggleLike(' . $row["PostID"] . ')">Liked</button>';
                        } else {
                            echo '<button type="button" class="likebutton" onclick="toggleLike(' . $row["PostID"] . ')">Like</button>';
                        }
                        echo '</div>';
                        echo '<div class="repbttn">
                            <button type="button" class="reportButton" onclick="openForm(' . $row["UserID"] . ', \'' . $row["PostID"] . '\',\'' . $row["FName"]. '\')">Report</button>
                        </div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                    }
                } else {
                    echo '<div>No posts found</div>';
                }
            ?>
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

                    <script>
                        function openForm(userID, postID, Fname) {
                            document.getElementById("myForm").style.display = "block";
                        // Populate UserID and PostID in the form fields
                        document.getElementById('UserID').value = userID;
                        document.getElementById('PostID').value = postID;
                        document.getElementById('FName').value = Fname;
                        // Show the form
                    }
                    function closeForm() {
                    // Close the report form
                    document.getElementById("myForm").style.display = "none";
                      }

                    function toggleDescription() {
                        // Toggle description input based on the selected option
                        var reportSelect = document.getElementById("report");
                        var descriptLabel = document.getElementById("descriptLabel");
                        var descriptInput = document.getElementById("descript");

                        if (reportSelect.value === "0") {
                            descriptLabel.style.display = "none";
                            descriptInput.style.display = "none";
                        } else {
                            descriptLabel.style.display = "block";
                            descriptInput.style.display = "block";
                        }
                    }
                    </script>

            <!-- Form Popup -->
            <div class="formm-popup" id="myForm">
            <form action="../adminpages/reportuser.php" method="post" class="formm-container">
                <h2>Submit Report</h2>
                <!-- Dropdown list -->
                <label for="report"><b>Report:</b></label>
                <select id="report" name="subject" onchange="toggleDescription()">
                    <option value="0" selected>Select</option>
                    <option value="1" id="postOption">Post</option>
                    <option value="2" id="userOption">User</option>
                </select>
                    <input type="hidden" id="UserID" name="UserID">
                    <input type="hidden" id="PostID" name="PostID">
                    <!-- Description input (initially hidden) -->
                    <label for="descript" id="descriptLabel" style="display: none;"><b>Description:</b></label>
                    <textarea name="descript" id="descript" cols="30" rows="8" style="display: none;" required></textarea>
                    <button type="submit" class="btn">Submit</button>
                    <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
            </form>
            </div>


        </div>
    

</div>
</body>
</html>