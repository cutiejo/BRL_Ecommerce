<?php
// Include the database connection
include '../connections.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCategory"])) {
    // Retrieve the category name from the form
    $categoryName = $_POST["categoryName"];

    // Validate the category name (you may add more validation here)

    // Insert the new category into the database
    $insertCategorySql = "INSERT INTO tbl_category (category_name) VALUES ('$categoryName')";

    if (mysqli_query($conn, $insertCategorySql)) {
        // Category added successfully
        // You can redirect the user or send a success message
        header("Location: category.php"); // Redirect to a relevant page
        exit;
    } else {
        echo "Error: " . $insertCategorySql . "<br>" . mysqli_error($conn);
    }
}
?>
