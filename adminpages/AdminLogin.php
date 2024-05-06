<?php 
include '../dbConnect.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $idnum = filter_var($_POST['AdminID'], FILTER_SANITIZE_NUMBER_INT);
        $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

        $find_user = $conn->prepare("SELECT * FROM administrator WHERE ID = ? AND Password = ? LIMIT 1");
        $find_user->bind_param("is", $idnum,$pass);
        $find_user->execute();
        $result = $find_user->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['ID'] == 1){
                setcookie('ID',$row['ID'], time() + 60*60*24*30, '/');
                header('location:SAdashboard.php');
                exit();
            }else{
                setcookie('ID',$row['ID'], time() + 60*60*24*30, '/');
                header('location:Adashb.php');
                exit();
            }
            }else{
                $message[] = 'Incorrect ID number or Password';
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
    <title>Log In-Admin</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <link rel="stylesheet" href="/css/AdminLogin.css">
</head>
<body>
<?php if(isset($message)){
    foreach($message as $msg){
       echo '
       <div class="message">
          <span>'.$msg.'</span>
          <i class="fas fa-times" onclick="removeMessage(this.parentElement);"></i>
       </div>
       ';
    }
}?>
<script>
    function removeMessage(element) 
        {
        element.classList.add("hide");
    }
    
</script>
<form method="POST" action="">
    <div class="centerdiv">
    <div class="container">

    
        <div class="signincont">
            
            <div class="buttoncont">
            <h1>ADMINISTRATOR</h1>
            </div>
    
                <div class="formcont">
                    <div class="emailcont">
                        <p>ID Number</p>
                        <input type="number" name="AdminID" required>
                    </div>
                    <div>
                        <div class="password-container">

                        <p>Password</p>

                        <span class="toggle-password" onclick="togglePasswordVisibility()">&#x1f441;</span>
                        
                        </div>
</br>
                        <input type="password" name="pass" id="PassTxtbx" recquired>
                        
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
                            <button type="submit"   class="sgnUP">LOG IN</button>
                    </div>
                </div>
            
        </div>
    </div>
</div>
</form>
</body>
</html>