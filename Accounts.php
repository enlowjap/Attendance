<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accountst</title>
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
        width: 950px;
        height: 450px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
    }
    .panel-title {
        color: #fff;
        position: absolute;
        top: 20px;
        left: 20px;
        margin: 0;
    }
    .tabs {
        display: flex;
        position: absolute;
        top: 20px;
        left: 20px;
    }
    .tab {
        padding: 8px 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px 5px 0 0;
        cursor: pointer;
        margin-right: 10px;
    }
    .tab.active {
        background-color: #0056b3;
    }
    .tab-content {
        padding: 20px;
        display: none;
        position: absolute;
        top: 60px;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .tab-content.active {
        display: block;
    }
    .postbtn {
        margin-top: 25px;
        padding: 10px 20px;
        width: 180px;
        background-color:  rgb(36, 37, 38);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }    
    .Accbtn {
        margin-top: 16px;
        padding: 10px 20px;
        width: 180px;
        background-color: #007bff;
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
    .add-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 8px 16px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .add-btn:hover {
        background-color: #218838;
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
        <h2 class="panel-title">Accounts</h2>
        <div class="panel">
            <div class="tabs">
                <button class="tab active" onclick="showTab('user')">User Account</button>
                <button class="tab" onclick="showTab('admin')">Admin Account</button>
            </div>                     
            <button class="add-btn">Add</button> <!-- Add button for Admin Account -->
            <div class="tab-content active" id="user-tab-content">
                User Account content goes here...
            </div>
            <div class="tab-content" id="admin-tab-content">
                Admin Account content goes here...
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        var tabs = document.querySelectorAll('.tab');
        var tabContents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });
        
        tabContents.forEach(function(content) {
            content.classList.remove('active');
        });
        
        document.getElementById(tabName + '-tab-content').classList.add('active');
        document.querySelector('.tab[data-tab="' + tabName + '"]').classList.add('active');
    }
</script>

</body>
</html>
