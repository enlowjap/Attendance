<?php
session_start();

include 'dbConnect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and trim whitespace
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // SQL query to insert data into the table
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // Return success message if data is inserted successfully
    } else {
        echo "error"; // Return error message if there was an error with the SQL query
    }
} else {
    echo "error"; // Return error message for invalid request method
}
?>
