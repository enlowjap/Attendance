<?php 

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/navigationheader.css">
</head>
<body>


<div class="containerr">
<div class="navbar">

    <div class="imglogo">
    <a href="/Landpage.php">
    <img src="/picture/bicycle.png" alt="logo">
    <p>G-BIKE</p>
    </a>
    </div>

    <div class="navbutton">
    <div><p>ABOUT</p></div>
    
    <div><p>CONTACT</p></div>
    
    <div class="navbuttonend"><a href="/Login.php"><p>SIGN IN</p></a></div>
    </div>
</div>

</div>

</body>
</html>