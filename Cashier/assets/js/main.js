// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};



/*product*/
document.addEventListener("DOMContentLoaded", function () {
  const productList = document.getElementById("productList");

  // Static product data (replace this with your actual data)
  const products = [
      { name: "Product 1", price: 50, description: "Description for Product 1" },
      { name: "Product 2", price: 75, description: "Description for Product 2" },
      { name: "Product 3", price: 100, description: "Description for Product 3" },
  ];

  // Loop through the products and create HTML elements
  products.forEach(product => {
      const productItem = document.createElement("div");
      productItem.classList.add("product-item");

      productItem.innerHTML = `
          <h3>${product.name}</h3>
          <p><strong>Price:</strong> $${product.price}</p>
          <p>${product.description}</p>
      `;

      productList.appendChild(productItem);
  });
});


/*dropdown pro*/
// Add this script to your HTML file or include it in an external JavaScript file
function toggleModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = modal.style.display === "block" ? "none" : "block";
}

// Close the modal when clicking outside of the modal content
window.onclick = function (event) {
  var modals = document.getElementsByClassName("modal");
  for (var i = 0; i < modals.length; i++) {
      var modal = modals[i];
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
};

/*modal add button*/
//-----------------------------------------------------------------------------------------------------------------------
// JavaScript for modal functionality
var addProductBtn = document.getElementById("addProductBtn");
var addProductModal = document.getElementById("addProductModal");
var editProductModal = document.getElementById("editProductModal");
var closeModal = document.getElementsByClassName("close");

addProductBtn.onclick = function () {
    addProductModal.style.display = "block";
};

closeModal[0].onclick = function () {
    addProductModal.style.display = "none";
};

closeModal[1].onclick = function () {
    editProductModal.style.display = "none";
};

window.onclick = function (event) {
    if (event.target === addProductModal) {
        addProductModal.style.display = "none";
    } else if (event.target === editProductModal) {
        editProductModal.style.display = "none";
    }
};
//-----------------------------------------------------------------------------------------------------------------------
function openEditModal(productId) {
    // You can use AJAX to fetch the existing product details based on productId
    // For simplicity, let's assume you have a PHP endpoint to retrieve product details
    // Replace 'get_product_details.php' with your actual endpoint
    fetch(`get_product_details.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            // Populate the form fields with the existing product details
            document.getElementById("editImage").value = ""; // Clear previous file input
            document.getElementById("editItemName").value = data.pname;
            document.getElementById("editCategory").value = data.pcategory;
            document.getElementById("editPrice").value = data.saleprice;
            document.getElementById("editStock").value = data.stock_quantity;
            document.getElementById("editDescription").value = data.pdescription;
            document.getElementById("editProductId").value = productId;

            // Open the edit product modal
            editProductModal.style.display = "block";
        })
        .catch(error => {
            console.error('Error fetching product details:', error);
        });
}

function closeEditModal() {
    editProductModal.style.display = "none";
}

//js ng pagination//
document.addEventListener("DOMContentLoaded", function () {
    var table = document.querySelector(".product-table");
    var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    var rowsPerPage = 4; // Updated to display 4 rows per page
    var currentPage = 1;

    function showRows() {
        var start = (currentPage - 1) * rowsPerPage;
        var end = start + rowsPerPage;

        for (var i = 0; i < rows.length; i++) {
            rows[i].style.display = (i >= start && i < end) ? "" : "none";
        }
    }

    function updatePaginationButtons() {
        var prevButton = document.getElementById("prevPageBtn");
        var nextButton = document.getElementById("nextPageBtn");

        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === Math.ceil(rows.length / rowsPerPage);
    }

    function changePage(delta) {
        currentPage += delta;
        showRows();
        updatePaginationButtons();
    }

    // Show initial set of rows and update pagination buttons
    showRows();
    updatePaginationButtons();

    // Attach click event listeners to pagination buttons
    document.getElementById("prevPageBtn").addEventListener("click", function () {
        changePage(-1);
    });

    document.getElementById("nextPageBtn").addEventListener("click", function () {
        changePage(1);
    });
});

//modal sa dropdown//
// Function to open modal
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Function to close modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Close modal if clicked outside the content
window.onclick = function(event) {
    if (event.target.className === "modal") {
        event.target.style.display = "none";
    }
}

//pop up log out//

function logout() {
    // You can add any additional logout logic here, such as redirecting to a logout script
    // For now, let's simulate a logout by displaying an alert
    alert("Logged out successfully!");
    
    // Close the logout modal
    closeModal('logoutModal');

    // You can redirect to your actual logout script or perform other logout actions here
    // Example: window.location.href = 'logout.php';
}


// Function to open the modal
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Function to close the modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Function to add a new category
function addCategory() {
    // You can add additional logic here, such as sending an AJAX request to add the category to the database
    alert("Category added successfully!"); // Display an alert for demonstration purposes

    // Close the modal after adding the category
    closeModal('addCategoryModal');
}



//view order//

function openOrderDetailsModal(orderId) {
    // Fetch order details from the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            var orderDetails = JSON.parse(xhr.responseText);

            // Update the modal content with order details
            document.getElementById('orderDetailsContent').innerHTML = "<h2>Order Details</h2>" +
                "<p>Product Name: " + orderDetails.product_name + "</p>" +
                "<p>Price: " + orderDetails.price + "</p>" +
                "<p>Order Date: " + orderDetails.order_date + "</p>" +
                "<p>Payment Method: " + orderDetails.payment_method + "</p>" +
                "<p>Order Status: " + orderDetails.order_status + "</p>" +
                "<p>Payment Status: " + orderDetails.payment_status + "</p>";

            // Display the modal
            document.getElementById('orderDetailsModal').style.display = 'block';
        }
    };
    xhr.open("GET", "get_order_details.php?order_id=" + orderId, true);
    xhr.send();
}

// Function to close the Order Details modal
function closeOrderDetailsModal() {
    document.getElementById('orderDetailsModal').style.display = 'none';
}

//order//
// Function to submit the form
function submitForm() {
    // Trigger the form submission using AJAX
    var formData = new FormData(document.getElementById('addOrderForm'));

    // Example using fetch and FormData for AJAX
    fetch('add_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            // Order added successfully, show the success modal
            showSuccessModal();
        } else {
            // Error occurred, handle it accordingly (e.g., show an error message)
            console.error('Error adding order:', data);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Function to show the success modal
function showSuccessModal() {
    document.getElementById('successModal').style.display = 'block';
}
