<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>2 Panel Layout</title>
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
    }
    .container {
        display: flex;
        height: 100%;
    }
    .sidebar {
        width: 180px;
        background-color: rgb(36, 37, 38);
        color: #fff;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .content {
        flex: 1;
        padding: 20px;
        background-color: #3A3B3C;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .panel {
        width: 750px;
        height: 450px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
    }
    .circle-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 10%;
        left: 10%;
        transform: translate(-50%, -50%);
    }
    .circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #007bff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .circle-text {
        color: #000;
        font-size: 18px;
        margin-left: 20px; /* Adjust spacing between circle and text */
    }
    .kebab-menu-container {
        position: absolute;
        top: 10%;
        right: 5%;
        transform: translate(50%, -50%);
    }
    .kebab-menu {
        width: 50px;
        height: 50px;
        background-color: #fff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        
    }
    .kebab-menu-icon {
        color: #000;
        font-size: 24px;
    }
    .panel-title {
        color: #fff;
        position: absolute;
        top: 20px;
        left: 20px;
        margin: 0;
    }
    .postbtn {
        margin-top: 25px;
        padding: 10px 20px;
        width: 180px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }    
    .Accbtn {
        margin-top: 16px;
        padding: 10px 20px;
        width: 180px;
        background-color: rgb(36, 37, 38);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .logout-button {
        margin-top: 22.5rem;
        width: 180px;
        background-color: rgb(36, 37, 38);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .panel2 {
        width: 750px;
        height: 379px;
        background-color: #007bff;
        position: absolute;
        top: 59%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    h2 {
        color: #fff;
    }
</style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>ADMIN</h2>
        <button class="postbtn">Post Management</button>
        <button class="Accbtn" style="margin-top: 16px;">Accounts</button>
        <button class="button logout-button">Logout</button>
    </div>
    <div class="content">
        <h2 class="panel-title">Post management</h2>
        <div class="panel">
            <div class="circle-container">
                <div class="circle"></div>
                <span class="circle-text">Yone</span>
            </div>
            <div class="kebab-menu-container">
                <div class="kebab-menu">
                    <span class="kebab-menu-icon">&#8942;</span>
                </div>
            </div>
            <div class="panel2"></div>
        </div>
    </div>
</div>

</body>
</html>
