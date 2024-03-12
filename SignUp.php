<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp!</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/Landpage.css">
    <link rel="stylesheet" href="/css/SignIn.Css">
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

            <div class="formcont">
                <div>
                    <p>First Name</p>
                    <input type="text" id="FnameTxtbx" name="First Name" oninput="capitalizeFirstname()">
                </div>
                <div>
                    <p>Last Name</p>
                    <input type="text" id="LnameTxtbx" name="Last Name" oninput="capitalizeLastname()">
                </div>
                <div>
                    <p>Email</p>
                    <input type="text" id="EmailTxtbx" name="Email@gmail.com">
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" id="PassTxtbx">
                    <span class="toggle-password" onclick="togglePasswordVisibility()">&#x1f441;</span>
                </div>

                <script>
                    function capitalizeFirstname() {
                         var input = document.getElementById("FnameTxtbx");
                             input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
                    }

                    function capitalizeLastname() {
                         var input = document.getElementById("LnameTxtbx");
                             input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
                    }

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



                <div class="checkbxCont">
                    <label for="TermsRdioBttn" class="chckbx">Terms Of Service
                        <input type="checkbox" id="TermsRdioBttn">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="sgnUPcont">
                    <button class="sgnUP">
                        SIGN UP
                    </button>
                </div>
            </div>
        
    </div>

    <div class="imgcont">
        <img src="/picture/Blue Minimalist Quotes  Desktop Wallpaper.png" alt="bg"/>
    </div>
</div>
</div>

</body>
</html>