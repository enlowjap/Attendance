<?php
include 'dbConnect.php';

if(isset($message)){
    foreach($message as $msg){
       echo '
       <div class="message">
          <span>'.$msg.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
    }
}

 try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

        $find_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1");
        $find_user->bind_param("ss", $email,$pass);
        $find_user->execute();
        $result = $find_user->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                setcookie('ID',$row['ID'], time() + 60*60*24*30, '/');
                header('location:Home.php');
            }else{
                $message[] = 'Incorrect Email or Password';
            }
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
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
<form action="" method="post" >
    <div class="centerdiv">
    <div class="container">

        <div class="signincont">
            
            <div class="buttoncont">
            <a href="/SignUp.php"><button class="sgnUp">Sign Up</button></a>
            
            <a href="/Login.php"><button class="sgnIn">Sign In</button></a>
            </div>
    
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
                        <a href="/Home.php">
                            <button  type="submit" class="sgnUP">SIGN IN</button>
                        </a>
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