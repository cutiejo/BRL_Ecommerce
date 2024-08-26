<?php
// Include the database connection
include '../connections.php';


// Include the HTML header

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
</head>
<style>
    .modal-content.small {
    width: 300px;
    
}

.modal-title {
    font-size: 1.2rem;
}

.modal-message {
    font-size: 1rem;
    margin-bottom: 2px;
}

.logout-actions {
    display: flex;
    justify-content: space-between;
}

.logout-btn,
.cancel-btn {
    padding: 8px 16px;
    font-size: 0.9rem;
}
</style>

<body>
    


         <!-- ================= User Table Container ========================================================== -->
    <!-- HTML Code -->
    <div class="user-table-container">
    <h2 class="user_table">User Table</h2>
    <div class="table-scroll-container">
        <table class="user_table_info">
            <thead class="user_thead">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>useremail</th>
                <th>Password</th>
                <th>Role</th> 
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody id="userTableBody">
            <!-- User data will be dynamically added here using JavaScript -->
        </tbody>
    </table>
</div>

<div class="add-user-container">
    <h2 class="user_form">Add User</h2>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" placeholder="Enter username">
    </div>
    <div class="form-group">
        <label for="useremail">Useremail:</label>
        <input type="text" id="useremail" placeholder="Enter useremail">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="Enter password">
    </div>
    <div class="form-group">
    <label for="role">Role:</label>
    <select id="role">
        <option value="cashier">Cashier</option>
        <option value="admin">Admin</option>
    </select>
</div>

    <div class="form-group">
        <button onclick="addUser()">Add User</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userTableBody = document.getElementById("userTableBody");

        function renderUsers(users) {
            userTableBody.innerHTML = "";
            users.forEach(user => {
                const row = createRow(user);
                userTableBody.appendChild(row);
            });
        }

        function createRow(user) {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${user.user_id}</td>
        <td>${user.username}</td>
        <td>${user.useremail}</td>
        <td>${user.password}</td>
        <td>${user.role}</td> <!-- Add Role column -->
        <td><button onclick="deleteUser(${user.user_id})">Delete</button></td>
    `;
    return row;
    }
        window.addUser = function () {
    const username = document.getElementById("username").value;
    const useremail = document.getElementById("useremail").value;
    const password = document.getElementById("password").value;
    const role = document.getElementById("role").value;

    if (!username || !useremail || !role || !password) {
        alert("Please enter name, password and role");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "add_user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);

                if ('error' in response) {
                    // Handle error case
                    alert(response.error);
                } else {
                    // User added successfully, update UI
                    const newUser = response;
                    renderUsers([newUser, ...users]);
                }
            } else {
                console.error("Error:", xhr.status, xhr.statusText);
            }
        }
    };
    xhr.send(`username=${encodeURIComponent(username)}&useremail=${encodeURIComponent(useremail)}&password=${encodeURIComponent(password)}&role=${encodeURIComponent(role)}`);

    document.getElementById("username").value = "";
    document.getElementById("useremail").value = "";
    document.getElementById("password").value = "";
    document.getElementById("role").value = "";
};

        window.deleteUser = function (userId) {
            // Implement this function if needed
        };

        // Fetch and render users initially
        getUsersAndRender();
        
        function getUsersAndRender() {
    fetch('get_users.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data && Array.isArray(data)) {
                users = data;
                renderUsers(users);
            } else {
                console.error('Invalid or empty JSON response from the server.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
    })
</script>



   


    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/mains.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>