
/*modal-                          // latest ------------------------------------------------------------------------------------------*/

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
            <td>${user.role}</td>
            <td><button onclick="deleteUser(${user.user_id})">Delete</button></td>
        `;
        return row;
    }
  
    window.addUser = function () {
        // ... (existing code for adding user)
        const username = document.getElementById("username").value;
        const useremail = document.getElementById("useremail").value;
        const password = document.getElementById("password").value;
        const role = document.getElementById("role").value;
    
        if (!username || !useremail || !role || !password) {
            alert("Please enter both name and password.");
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

    //-----------------------------------------------------------------------------------------------------------------
  
   window.deleteUser = function (user_id) {
    // Ask for confirmation before deleting
    const confirmation = confirm('Are you sure you want to delete this user?');

    if (confirmation) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_user.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
  
                    if ('error' in response) {
                        // Handle error case
                        alert(response.error);
                    } else {
                        // User deleted successfully, update UI
                        getUsersAndRender();
                    }
                } else {
                    console.error("Error:", xhr.status, xhr.statusText);
                }
            }
        };
        xhr.send(`deleteUserId=${encodeURIComponent(user_id)}`);
    }
};

  //------------------------------------------------------------------------------------------------------------
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
  });