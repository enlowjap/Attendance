<?php
// Check if data is received via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve admin name and password from POST data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validate input (you can add more validation as needed)
    if (!empty($name) && !empty($password)) {
        // Database connection
        include 'dbConnect.php'; // Assuming dbConnect.php contains your database connection code

        // Prepare and execute SQL query to insert admin data
        $insert_query = $conn->prepare("INSERT INTO Administrator (Name, Password) VALUES (?, ?)");
        $insert_query->bind_param("ss", $name, $password);
        
        if ($insert_query->execute()) {
            echo "Admin added successfully!";
        } else {
            echo "Error: Unable to add admin.";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "Error: Invalid input data.";
    }
} else {
    echo "Error: Invalid request.";
}
?>