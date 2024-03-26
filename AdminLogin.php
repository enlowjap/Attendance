<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/AdminLogin.css">
</head>
<body>

    <div class="centerdiv">
    <div class="container">

    
        <div class="signincont">
            
            <div class="buttoncont">
            <h1>ADMINISTRATOR</h1>
            </div>
    
                <div class="formcont">
                    <div class="emailcont">
                        <p>ID Number</p>
                        <input type="text" id="EmailTxtbx" name="Email@gmail.com">
                    </div>
                    <div>
                        <div class="password-container">

                        <p>Password</p>

                        <span class="toggle-password" onclick="togglePasswordVisibility()">&#x1f441;</span>
                        
                        </div>
</br>
                        <input type="password" id="PassTxtbx">
                        
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
                    </script>
    
                    <div class="sgnUPcont">
                        <a href="/Postmanagement.php">
                            <button   class="sgnUP">LOG IN</button>
                        </a>
                    </div>
                </div>
            
        </div>
    </div>
</div>
</body>
</html>