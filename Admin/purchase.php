<?php
include '../connections.php';

// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    //echo "Connected successfully";
}

// Fetch products data for later use
$productsQuery = "SELECT p.pname, p.pimage FROM tbl_product p";
$productsResult = mysqli_query($conn, $productsQuery);

if (!$productsResult) {
    die("Error fetching products: " . mysqli_error($conn));
}
//stock notif//
// Sample values (replace these with your actual data)
$stock = 10; 
$orderedQuantity = 3; 
$productName = "Example Product"; 

// Before adding an order, check stock quantity and set a flag for low stock
$lowStock = false; // Initialize the flag
if ($stock <= 5) {
    $lowStock = true;
}

//


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
    <!-- Add this line to import jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>

</head>
<style>

.form-dropdown {
    position: relative;
    display: inline-block;
}

.form-dropdown select {
    appearance: none; 
    -webkit-appearance: none;
    -moz-appearance: none; 
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    box-sizing: border-box;
}

.form-dropdown select:after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    
    transform: translateY(-50%);
}

.form-dropdown select option {
    background-color: #fff;
    color: #0000;
    padding: 10px;
}

.form-dropdown select option:checked {
    background-color: #3498db;
    color: #fff;
}

.form-columns {
    display: flex;
}

.form-column {
    flex: 1;
    margin-right: 20px;
}

.form-column:last-child {
    margin-right: 0;
}


#addOrderForm label {
    display: block;
    margin-bottom: 10px;
    margin: 15px;
}

#addOrderForm input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

    #addOrderForm input,
    #addOrderForm select {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    #addOrderForm button {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #addOrderForm button:hover {
        background-color: #45a049;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        width: 50%;
    } 
    .order-content {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: white;
    }

    .close-btn {
            position: absolute;
            top: 2px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #aaa;
            float: right;
            font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
    }


    #orderListTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#orderListTable th,
#orderListTable td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

#orderListTable th {
    background-color: #33394a;
    color: white;
}

#orderListTable tbody tr:hover {
    background-color: #f5f5f5;
}

.orderListTable button {
    border: none;
    cursor: pointer;
    padding: 5px;
}

.orderListTable button ion-icon {
    font-size: 20px;
    color: #333;
}

#orderListTable button.print {
    background-color: #3498db; 
}

#orderListTable button.edit {
    background-color: #4CAF50; 
}

#orderListTable button.delete {
    background-color: #e74c3c; 
}

#orderListTable button:hover {
    background-color: #ddd;
}


#horizontalViewOrderTable {
        display: flex;
        flex-direction: row;
        overflow-x: auto; /* Enable horizontal scrolling if needed */
    }

    #viewOrderTable th,
    #viewOrderTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        min-width: 100px; /* Set a minimum width for the cells */
    }

    #viewOrderTable th {
        background-color: #33394a;
        color: white;
    }

    #viewOrderTable tbody tr:hover {
        background-color: #f5f5f5;
    }

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
    
            
            <!-- ================= Purchase Order List ================ -->
        
        <!-- ================= Order Content ================ -->
        <div class="order-content">
            <h2 class="content-header">Orders</h2><br>

            <button id="openAddOrderModal"><ion-icon name="add-circle-outline"></ion-icon>Add Order</button>



            <!-- Order List Table -->
    <table id="orderListTable">
        <thead>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Order Date</th>
                <th>Quantity</th>
                <th>Paid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="orderListTableBody">
    <!-- Order data will be dynamically populated here -->
</tbody>

    </table>
</div>

<script>
    fetch('fetch_orders.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(orders => {
        console.log('Fetched Orders:', orders);

        // Assuming you have a function to populate the order list table
populateOrderListTable(orders);

// You can perform additional operations or update the UI here

// Attach event listener to the edit buttons
attachEditButtonListeners();


// Function to attach event listeners to edit buttons
function attachEditButtonListeners() {
    var editButtons = document.querySelectorAll('.edit');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var orderId = button.dataset.orderId;
            var existingStock = button.dataset.stock;
            var existingSalePrice = button.dataset.salePrice;
            var existingTotal = button.dataset.total;
            openEditOrderModal(orderId, existingStock, existingSalePrice, existingTotal);
        });
    });
}


    })
    .catch(error => {
        console.error('Error fetching orders:', error.message);

        // Handle the error gracefully, e.g., display an error message to the user

    });

// Function to populate order list table
function populateOrderListTable(orders) {
    var tableBody = document.getElementById('orderListTableBody');
    tableBody.innerHTML = '';

    for (var i = 0; i < orders.length; i++) {
        var order = orders[i];
        var row = tableBody.insertRow(i);

        // Assuming you have a function to format the order date (replace with actual function)
        var formattedOrderDate = formatOrderDate(order.order_date);

        // Populate table cells
        var cellNo = row.insertCell(0);
        cellNo.innerHTML = i + 1;

        var cellProductName = row.insertCell(1);
        cellProductName.innerHTML = order.product_name;  // Update with the correct column name

        var cellOrderDate = row.insertCell(2);
        cellOrderDate.innerHTML = formattedOrderDate;  // Update with the correct column name

        var cellQuantity = row.insertCell(3);
        cellQuantity.innerHTML = order.quantity;  // Update with the correct column name

        var cellTotal = row.insertCell(4);
        cellTotal.innerHTML = order.price;  // Update with the correct column name

        // Inside the populateOrderListTable function
        var cellActions = row.insertCell(5);
        cellActions.innerHTML = `
        <button class="print" title="Print" onclick="console.log('Print button clicked'); printReceipt(${order.order_id}, '${order.product_name}', '${order.order_date}', ${order.quantity}, ${order.price}, ${order.paid})">
    <ion-icon name="print-outline"></ion-icon>
  </button>
            <button class="delete" title="Delete" data-order-id="${order.order_id}"><ion-icon name="trash-outline"></ion-icon></button>
        `;
    }
    
    // Attach a delegated event listener for delete buttons
    tableBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete')) {
            var orderId = event.target.dataset.orderId;
            deleteOrder(orderId);
        }
    });
}




// Function to format order date (replace with actual function if needed)
function formatOrderDate(rawDate) {
    // Example: Format the date as YYYY-MM-DD
    var date = new Date(rawDate);
    var formattedDate = date.toISOString().split('T')[0];
    return formattedDate;
}


</script>





        <!-- ================= Add Order Form ================ -->


         <!-- Add Order Form -->
    <div id="addOrderModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeAddOrderModal()">×</span>
            <h2>Add Order</h2>

            <!-- Add Order Form -->
            <form id="addOrderForm" action="" method="POST">

    <div class="form-columns">
        <!-- Left Column -->
        <div class="form-column">
        <label for="productName">Name of Product:</label>
        <select id="pname" name="productName" onchange="fetchProductDetails(this.value)" required>
        
            <option value="" disabled selected>Select a Product</option>
                
                <!-- Options will be dynamically populated -->
            </select>

            <label for="salePrice">Sale Price:</label>
            <input type="text" id="salePrice" name="salePrice" readonly required>

            <label for="stock">Stock:</label>
            <input type="text" id="stock" name="stock" readonly required>

        </div>
        <!-- Right Column -->
        <div class="form-column">
            <label for="orderDate">Order Date:</label>
            <input type="date" id="orderDate" name="orderDate" required>

            <!-- Note about payment method in placeholder -->
            <label for="paymentMethod">Payment Method:</label>
            <input type="text" id="paymentMethod" name="paymentMethod" placeholder="Cash only" readonly
                   style="background-color: #f2f2f2; color: #555; cursor: not-allowed;" required>

                   <label for="quantity">Enter Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                </div>
            </div>
           
            <div style="text-align: center; margin-top: 20px;">
        <button type="submit" id="submitAddOrderForm">Add Purchase</button>
    </div>
        </form>
    </div>
</div>

<script>
    // Function to add a purchase
function addPurchase() {
    // Fetch form data
    var formData = new FormData(document.getElementById('addOrderForm'));

    // Make a Fetch API request to add a purchase
    fetch('add_order.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            
            // Update the UI with the new order
            fetch('fetch_orders.php')
                .then(response => response.json())
                .then(orders => {
                    // Populate the order list table with the updated data
                    populateOrderListTable(orders);

                    // Attach event listener to the edit buttons
                    attachEditButtonListeners();
                })
                .catch(error => {
                    console.error('Error fetching orders:', error.message);
                });

            // Close the modal or update the UI as needed
            closeAddOrderModal();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error adding purchase:', error.message);
    });
}

    // JavaScript for form validation

// JavaScript for form validation
function validateForm() {
    // Fetch form data
    var productName = document.getElementById('pname').value;
    var salePrice = document.getElementById('salePrice').value;
    var stock = parseInt(document.getElementById('stock').value); // Parse stock quantity as integer
    var orderDate = document.getElementById('orderDate').value;
    var quantity = parseInt(document.getElementById('quantity').value); // Parse entered quantity as integer

    // Check if the entered quantity exceeds the available stock
    if (quantity > stock) {
        alert("Sorry, quantity not available.");
        return false;
    }

    // Example: Check if the product name is selected
    if (productName === "") {
        alert("Please select a product");
        return false;
    }

    // Add more validation checks as needed

    return true; // Submit the form if all validations pass
}



    // JavaScript for the modal functionality
    document.getElementById('openAddOrderModal').addEventListener('click', function () {
        document.getElementById('addOrderModal').style.display = 'block';
    });

    window.addEventListener('click', function (event) {
        var modal = document.getElementById('addOrderModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    function closeAddOrderModal() {
        document.getElementById('addOrderModal').style.display = 'none';
    }

//
// JavaScript for form validation
document.getElementById('addOrderForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Validate the form
    if (validateForm()) {
        // If the form is valid, add the purchase
        addPurchase();
    }
});

fetch('', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        productName: document.getElementById('pname').value,
        salePrice: document.getElementById('salePrice').value,
        stock: document.getElementById('stock').value,
        orderDate: document.getElementById('orderDate').value,
        quantity: document.getElementById('quantity').value,
    }),
})
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
})
.then(data => {
    // Handle the parsed JSON data here
    console.log(data);

    // You can update the UI or perform additional actions as needed
})
.catch(error => {
    console.error('Error:', error.message);

    // Handle errors and display a user-friendly message
});

//
// Function to fetch product options and populate the dropdown
function fetchProductOptions() {
    var productDropdown = document.getElementById('pname');

    // Clear existing options
    productDropdown.innerHTML = '<option value="" disabled selected>Select a Product</option>';

    // Make a Fetch API request to fetch product options
    fetch('fetch_product_options.php')
        .then(response => response.json())
        .then(products => {
            // Log the fetched product options
            console.log('Fetched Product Options:', products);

            // Populate the dropdown with fetched product options
            products.forEach(product => {
                var option = document.createElement('option');
                option.value = product;  // Assuming 'product' is the product name
                option.textContent = product;
                productDropdown.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching product options:', error.message);
        });
}


// Function to fetch product details based on the selected product
function fetchProductDetails(selectedProduct) {
    console.log('Selected Product:', selectedProduct);

    // Make a Fetch API request to fetch product details based on the selected product
    fetch('fetch_product_details.php?pname=' + encodeURIComponent(selectedProduct))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(productDetails => {
            // Log the fetched product details
            console.log('Fetched Product Details:', productDetails);

            // Update the UI with the fetched product details
            document.getElementById('salePrice').value = productDetails.saleprice;
            document.getElementById('stock').value = productDetails.stock_quantity;

            // Check for low stock and display notification
            if (parseInt(productDetails.stock_quantity) <= 5) {
                alert('Low stock! Only ' + productDetails.stock_quantity + ' remaining for ' + selectedProduct);
            }
        })
        .catch(error => {
            console.error('Error fetching product details:', error.message);
        });
}

// Call the fetchProductOptions function to populate the dropdown on page load
fetchProductOptions();



//delete//

// Function to handle order deletion
function deleteOrder(orderId) {
        // Ask for confirmation before deleting
        var confirmDelete = confirm('Are you sure you want to delete this order?');

        if (confirmDelete) {
            // Make a Fetch API request to delete the order
            fetch('delete_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'order_id=' + orderId,
            })
            .then(response => response.json())
            .then(data => {
                console.log('Delete Order Response:', data);

                if (data.success) {
                    alert(data.message);

                    // Update the UI after successful deletion
                    fetch('fetch_orders.php')
                        .then(response => response.json())
                        .then(orders => {
                            populateOrderListTable(orders);
                            attachEditButtonListeners();
                        })
                        .catch(error => {
                            console.error('Error fetching orders:', error.message);
                        });
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting order:', error.message);
                alert('Error deleting order. Please check the console for more details.');
            });
        }
    }

//pdf//
function printReceipt(orderId, productName, orderDate, quantity, total) {
  // Create an HTML element with the receipt content
  const receiptContent = `
    <div style="width: 70mm; height: 130mm; margin: auto; padding: 10px; border: 1px dotted #000; font-family: 'Courier New', monospace; border-radius: 5px; background-color: #FFF;">
      <div style="text-align: center; margin-bottom: 20px; border: 0px solid #000; padding: 10px;">
        <img src="./assets/imgs/logo_brl.png" alt="Logo" style="max-width: 140%; max-height: 80px;">
      </div>
      <h2 style="text-align: center; margin-bottom: 30px; font-size: 18px; font-weight: bold; font-family: 'Arial', sans-serif; border-bottom: 1px solid #000; padding-bottom: 10px;">BRL Trading</h2>
      <p style="text-align: justice; font-size: 12px; margin: 0;">General Trias, Cavite </p>
      <p style="text-align: justice; font-size: 12px; margin: 0;">Contact Number: 09192737343</p>
    
      <div style="margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
          <tr>
            <td style="font-size: 12px; font-weight: bold; padding: 5px;">Product Name:</td>
            <td style="font-size: 12px; padding: 5px;">${productName}</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-weight: bold; padding: 5px;">Order Date:</td>
            <td style="font-size: 12px; padding: 5px;">${orderDate}</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-weight: bold; padding: 5px;">Quantity:</td>
            <td style="font-size: 12px; padding: 5px;">${quantity}</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-weight: bold; padding: 5px;">Total:</td>
            <td style="font-size: 12px; padding: 5px;">${total}</td>
          </tr>
        </table>
      </div>

      <p style="text-align: center; margin-top: 50px; font-size: 10px;">Thank you for choosing BRL Trading</p>
      <p style="text-align: center; font-size: 10px;">Hope you liked it</p>
      <p style="text-align: center; font-size: 10px;">--------------------------------------------</p>
    </div>
  `;

  // Convert the HTML element to PDF using html2pdf
  html2pdf(receiptContent, {
    margin: 5,
    filename: `receipt_order_${orderId}.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: [80, 140], orientation: 'portrait' },
  });
}


</script>




    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>
    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>

