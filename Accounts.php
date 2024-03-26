<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accounts</title>
<link rel="icon" href="/picture/bicycle.png" type="image/png">
<style>
    body, html {
        font-family:Arial;
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
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    th:first-child, td:first-child {
        border-left: none;
    }
    th:last-child, td:last-child {
        border-right: none;
    }
    tr:hover {
        background-color: #f5f5f5;
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
        <a href="/Postmanagement.php"><button class="postbtn">Post Management</button></a>

        <a href="/Accounts.php"><button class="Accbtn" style="margin-top: 16px;">Accounts</button></a>

        <a href="/AdminLogin.php"><button class="button logout-button">Logout</button></a>
    </div>
    <div class="content">
        <h2 class="panel-title">Accounts</h2>
        <div class="panel">
            <div class="tabs">
                <button class="tab active" onclick="showTab('user')">User Account</button>
                <button class="tab" onclick="showTab('admin')">Admin Account</button>
            </div>                     
            <button class="add-btn" id="addBtn">Add</button>
            <div class="tab-content active" id="user-tab-content">
                <h3>User Account Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date created</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1001</td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>2022-03-15</td>
                            <td>User</td>
                        </tr>
                        <tr>
                            <td>1002</td>
                            <td>Jane Smith</td>
                            <td>jane@example.com</td>
                            <td>2022-03-16</td>
                            <td>User</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
            <div class="tab-content" id="admin-tab-content">
                <h3>Admin Account Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date created</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2001</td>
                            <td>Admin 1</td>
                            <td>admin1@example.com</td>
                            <td>2022-03-15</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2002</td>
                            <td>Admin 2</td>
                            <td>admin2@example.com</td>
                            <td>2022-03-16</td>
                            <td>Admin</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelector('#' + tabName + '-tab-content').classList.add('active');
        document.querySelector('.tab[data-tab="' + tabName + '"]').classList.add('active');
        
        // Hide the Add button when switching to the User Account tab
        if (tabName === 'user') {
            document.getElementById('addBtn').style.display = 'none';
        } else {
            document.getElementById('addBtn').style.display = 'block';
        }
    }
</script>

</body>
</html>
