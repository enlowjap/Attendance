<?php
session_start();

include 'dbConnect.php';

// Initialize an array to store error messages
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (!$email) {
        $errors[] = "Invalid email format";
    }

    // Sanitize password (you may want to hash the password securely before storing it in the database)
    $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    // Proceed with login if there are no errors
    if (empty($errors)) {
        try {
            // Prepare and execute SQL statement
            $find_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1");
            $find_user->bind_param("ss", $email, $password);
            $find_user->execute();
            $result = $find_user->get_result();

            if ($result->num_rows > 0) {
                // If login is successful, set session variables and redirect
                $row = $result->fetch_assoc();
                setcookie('ID',$row['ID'], time() + 60*60*24*30, '/');
                $_SESSION['user_id'] = $row['ID'];
                header('location: like_and_post_test.php');
                exit;
            } else {
                $errors[] = 'Incorrect Email or Password';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Display error messages if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<div class="message"><span>' . $error . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/logIn.css">
</head>
<body>
<?php
    include 'navigationheader.php';
?>

    <div class="centerdiv">
    <div class="container">

        <div class="signincont">
            
            <div class="buttoncont">
            <a href="/SignUp.php"><button class="sgnUp">Sign Up</button></a>
            
            <a href="/Login.php"><button class="sgnIn">Sign In</button></a>
            </div>
            <form action="" method="post" >
                <div class="formcont">
                <div class="emailcont">
                    <p>Email</p>
                    <input type="email" id="EmailTxtbx" name="email" required>
                    <span id="emailError" style="color: red;"></span>
                </div>
                    <div>
                        <p>Password</p>
                        <input type="password" id="PassTxtbx" name="pass" recquired>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">&#x1f441;</span>
                    </div>
    
                    <script>
                        function togglePasswordVisibility() {
                            var passwordInput = document.getElementById('PassTxtbx');
                            var toggleIcon = document.querySelector('.toggle-password');
                
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                toggleIcon.textContent = '👁️';
                            } else {
                                passwordInput.type = 'password';
                                toggleIcon.textContent = '🔒';
                            }
                        }
                                                    
                            document.getElementById('EmailTxtbx').addEventListener('input', function() {
                                var emailInput = document.getElementById('EmailTxtbx');
                                var emailError = document.getElementById('emailError');
                                if (/[^a-zA-Z0-9@._-]/.test(emailInput.value)) {
                                    emailError.textContent = 'Email cannot contain special characters';
                                } else {
                                    emailError.textContent = '';
                                }
                                });
                    </script>
    
                    <div class="sgnUPcont">
                            <button  type="submit" class="sgnUP">SIGN IN</button>
                    </div>
                </div>
            
        </div>
        <div class="imgcont">
            <img src="/picture/Blue Minimalist Quotes  Desktop Wallpaper.png" alt="bg"/>
        </div>
    </div>
</div>
</form>
</body>
</html>