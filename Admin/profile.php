<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Profile Modal</title>
    <style>
        /* Add your custom styles here */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>

    <!-- Button to open the modal -->
    <button id="openModalBtn">Open Profile</button>

    <!-- The Modal -->
    <div id="profileModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="dropdown" id="profileDropdown">
                <button onclick="toggleDropdown()" id="profileBtn">Your Profile</button>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                    <a href="#" class="logout">Logout</a>
                </div>
            </div>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

    </div>

    <script>
        // JavaScript for modal functionality
        var modal = document.getElementById('profileModal');
        var openModalBtn = document.getElementById('openModalBtn');
        var dropdown = document.getElementById('profileDropdown');

        // Function to open the modal
        function openModal() {
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function (event) {
            if (event.target === modal) {
                closeModal();
            }
        };

        // Toggle the dropdown menu
        function toggleDropdown() {
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }

        // Open the modal when the button is clicked
        openModalBtn.onclick = function () {
            openModal();
        };
    </script>

</body>

</html>
