<!-- delete_modal.php -->

<?php
// You may include 'product.php' or any other necessary files here
?>

<div id="customDeleteConfirmationModal" class="custom-modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('customDeleteConfirmationModal')">&times;</span>

        <h2>Delete Product</h2>
        <p class="modal-message">Are you sure you want to delete this product?</p>
        <div class="delete-actions">
            <button class="custom-delete-btn" onclick="confirmDelete()">Delete</button>
            <button class="custom-cancel-btn" onclick="closeModal('customDeleteConfirmationModal')">Cancel</button>
        </div>
    </div>
</div>

<!-- Include the necessary CSS and JavaScript for modal styling and functionality -->
<style>
    /* Your specific styles for delete_modal.php */
    .custom-modal {
        background-color: white;
        

    }

    .custom-delete-btn {
        /* Customize delete button styles here */
        background-color: darkred;
        color: white;
    }

    .custom-cancel-btn {
        /* Customize cancel button styles here */
        background-color: #999;
        color: white;
    }

    /* Additional or override styles specific to delete_modal.php */
</style>

<!-- Include the necessary JavaScript for modal functionality -->
<script>
    // Add your modal-related JavaScript code here
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Add other modal-related JavaScript functions as needed
</script>
