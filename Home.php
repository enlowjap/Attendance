<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/Home.css">
</head>
<body>
    
<nav>
        <ul>
            
            <li><a href="/Home.php">Home</a></li>
            <li><a href="/UserProfile.php">Profile</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <div class="panel left-panel">
            <!-- Left panel content -->
            <h2>Trending Location</h2>
            <hr class="trending-line">
            <ul>
                <li># Placeholder Location 1</li>
                <li># Placeholder Location 2</li>
                <li># Placeholder Location 3</li>
            </ul>
        </div>
        <div class="search-box">
            <!-- Search box -->
            <input type="text" id="searchInput" placeholder="Where To?" />
        </div>
        
        <div class="Share-Route">
            <!-- Share Route content -->
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
                    <button class="create-btn">Create</button>
                </div>
            </div>            
        </div>
        <div class="panel right-panel">
            <!-- Right panel content -->
            <h2>My Routes</h2>
            <hr class="trending-line1">
            <ul>
                <li># Placeholder Route 1</li>
                <li># Placeholder Route 2</li>
                <li># Placeholder Route 3</li>
            </ul>
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

</body>
</html>