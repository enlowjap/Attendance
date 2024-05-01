<?php
include '../dbConnect.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO Users (FName, LName, Gender, BirthDate, Email, Password, CreatedDate, Status) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'active')");

// Bind parameters
$stmt->bind_param("ssssss", $fname, $lname, $gender, $birthdate, $email, $password);

// Set parameters and execute
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$email = $_POST['email'];
$password = $_POST['password'];

$stmt->execute();

session_start();

$message = array();


$message[] = 'New Account Inserted..';


$_SESSION['message'] = $message;


header('location: Accounts.php');
exit();

$stmt->close();
$conn->close();
?>