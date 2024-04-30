<?php
include 'dbConnect.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $fname = filter_var($_POST['FirstName'], FILTER_SANITIZE_STRING);
            $lname = filter_var($_POST['LastName'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['Email'], FILTER_SANITIZE_STRING);
            $pass = filter_var($_POST['Pass'], FILTER_SANITIZE_STRING);
            $gender = $_POST['gender'];
            $birthday =$_POST['selected_date'];
            $formatted_birthday = date('Y-m-d', strtotime($birthday));
    
            $find_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $find_email->bind_param("s", $email);
            $find_email->execute();
            $result = $find_email->get_result();

            if ($result->num_rows > 0) {
                $message[] = 'Email used is taken..';
            } else {
                $insert_user = $conn->prepare("INSERT INTO users (FName, LName, Gender, BirthDate, Email, Password, CreatedDate) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
                $insert_user->bind_param("ssssss", $fname, $lname, $gender, $birthday, $email, $pass);
                if ($insert_user->execute()) {
                    $message[] = 'Account Created!';
                    header('location:Login.php');
                } else {
                    $message[] = 'Error: Account creation failed.';
                }
            }

            $conn->close();
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
    <title>SignUp!</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
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


        <form action="" method="post" >
            <div class="formcont">
                <div>
                    <p>First Name</p>
                    <input type="text" name="FirstName" id="FnameTxtbx" oninput="capitalizeFirstname()" required>
                    <script>
                    function capitalizeFirstname() {
                         var input = document.getElementById("FnameTxtbx");
                             input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
                    }
                    </script>
                </div>
                <div>
                    <p>Last Name</p>
                    <input type="text"  name="LastName" id="LnameTxtbx"   oninput="capitalizeLastname()" required>
                    <script>
                    function capitalizeLastname() {
                         var input = document.getElementById("LnameTxtbx");
                             input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
                    }
                    </script>
                </div>
                <div>
                    <p>Gender <span style="color:red">*</span></p>
                    <div> <select id="dropdown" name="gender" >
                    <option selected>~~</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                </select></div>
                </div>
                <div>
                    <p>Birth Date <span style="color:red">*</span></p>
                    <div>
                        <input type="text" id="datepicker" name="selected_date" readonly >
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <style>
                        /* Hide the calendar button */
                        .ui-datepicker-trigger {
                            display: none;
                        }
                    </style>
                    <script>
                        $(function() {
                            // Initialize datepicker with disabled text input
                            $("#datepicker").datepicker({
                                // Hide text input
                                buttonText: "Select date",
                                // Disable text input
                                beforeShow: function(input, inst) {
                                    setTimeout(function() {
                                        inst.dpDiv.css({ marginTop: 0, marginLeft: 0 });
                                    }, 0);
                                },
                                // Show dropdown list for selecting year
                                changeYear: true,
                                // Control the range of selectable years
                                yearRange: "c-100:c+10", // 100 years in the past and 10 years in the future
                                // Show the calendar when clicking on the textbox
                                onClose: function() {
                                    $(this).datepicker('show');
                                }
                            });
                        });
                    </script>


                            

                </div>
                <div>
                    <p>Email</p>
                    <input type="email" name="Email" required>
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="Pass" required>
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
                </script>



                <div class="checkbxCont">
                    <label for="TermsRdioBttn" class="chckbx">Terms Of Service
                        <input type="checkbox" id="TermsRdioBttn" required>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="sgnUPcont">
                    <button type="submit" class="sgnUP">
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
</form>

</body>
</html>